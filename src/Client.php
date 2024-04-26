<?php

declare(strict_types=1);

namespace Albion\Status;

use Albion\Status\Decorators\ResponseStateDTODecorator;
use Albion\Status\DTOs\ServiceStateDTO;
use Albion\Status\Enums\RealmStatusHost;
use Albion\Status\Models\Version;
use Lukasoppermann\Httpstatus\Httpstatuscodes;
use Psr\Http\Client\ClientInterface;
use SimpleXMLElement;

class Client
{
    public function __construct(protected ClientInterface $client)
    {
    }

    /**
     * @description Get primary service status state
     *
     * @param RealmStatusHost $host
     *
     * @return \Albion\Status\DTOs\ServiceStateDTO
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function getServiceStatus(RealmStatusHost $host): ServiceStateDTO
    {
        return (new ResponseStateDTODecorator())
            ->decorate(
                $this->client->get(
                    $host->value,
                    [
                        'http_errors' => false,
                    ]
                )
            );
    }

    /**
     * @description Fetches current client version
     *
     * @return Version|null
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
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
                $versions = [];

                foreach ($platforms as $platform) {
                    $versions[$platform->getName()] = (string) $platform->fullinstall->attributes()->version;
                }

                return new Version(
                    $versions['win32'] ?? null,
                    $versions['linux'] ?? null,
                    $versions['macosx'] ?? null,
                    $versions['androidplaystore'] ?? null,
                    $versions['ios'] ?? null,
                );
            }
        }

        return null;
    }
}
