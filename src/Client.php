<?php

namespace Albion\Status;

use Albion\Status\Decorators\ResponseStateDTODecorator;
use Albion\Status\DTOs\ServiceStateDTO;
use Albion\Status\Models\Version;
use GuzzleHttp\Client as HttpClient;
use Lukasoppermann\Httpstatus\Httpstatuscodes;
use SimpleXMLElement;

class Client
{
    /** @var HttpClient */
    protected $client;

    /**
     * AlbionServiceStatusService constructor.
     */
    public function __construct()
    {
        $this->client = new HttpClient(
            [
                'timeout' => 90,
            ]
        );
    }

    /**
     * Get primary service status state
     * @return \Albion\Status\DTOs\ServiceStateDTO
     */
    public function getServiceStatus(): ServiceStateDTO
    {
        return (new ResponseStateDTODecorator())
            ->decorate(
                $this->client->get(
                    'http://serverstatus.albiononline.com/',
                    [
                        'http_errors' => false,
                    ]
                )
            );
    }

    /**
     * Get secondary service status state
     * @return string
     */
    public function getMaintenanceStatus(): ?string
    {
        $response = $this->client->get('http://live.albiononline.com/status.txt', ['http_errors' => false]);

        if($response->getStatusCode() === Httpstatuscodes::HTTP_OK) {
            return $response->getBody()->getContents();
        }

        return null;
    }

    public function getClientVersion(): ?Version
    {
        $response = $this->client->get(
            'https://live.albiononline.com/autoupdate/manifest.xml',
            ['http_errors' => false]
        );

        if($response->getStatusCode() === Httpstatuscodes::HTTP_OK) {
            $xml  = new SimpleXMLElement($response->getBody()->getContents());
            $platforms = $xml->xpath("//albiononline/*");

            if($platforms) {
                $version = new Version;

                foreach ($platforms as $platform) {
                    switch ($platform->getName()) {
                        case 'win32':
                            $version->setWindows((string) $platform->fullinstall->attributes()->version);
                            break;

                        case 'macosx':
                            $version->setOSX((string) $platform->fullinstall->attributes()->version);
                            break;

                        case 'linux':
                            $version->setLinux((string) $platform->fullinstall->attributes()->version);
                            break;

                        case 'androidplaystore':
                            $version->setAndroid((string) $platform->fullinstall->attributes()->version);
                            break;

                        case 'ios':
                            $version->setIOS((string) $platform->fullinstall->attributes()->version);
                            break;
                    }
                }

                return $version;
            }
        }

        return null;
    }
}