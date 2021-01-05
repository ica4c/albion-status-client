<?php

namespace Albion\Status;

use Albion\Status\Decorators\ResponseStateDTODecorator;
use Albion\Status\DTOs\ServiceStateDTO;
use Albion\Status\Models\State;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\RequestException;

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
        return (new ResponseStateDTODecorator)
            ->decorate(
                $this->client->get('http://serverstatus.albiononline.com/')
            );
    }

    /**
     * Get secondary service status state
     * @return \Albion\Status\DTOs\ServiceStateDTO
     */
    public function getMaintenanceStatus(): ServiceStateDTO
    {
        return (new ResponseStateDTODecorator)
            ->decorate(
                $this->client->get('http://live.albiononline.com/status.txt')
            );
    }
}