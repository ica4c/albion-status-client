<?php

declare(strict_types=1);

namespace Albion\Status\Decorators;

use Albion\Status\DTOs\ServiceStateDTO;
use Albion\Status\Enums\ServerState;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ResponseStateDTODecorator
{
    public function decorate(ResponseInterface $response): ServiceStateDTO
    {
        try {
            $data = trim($response->getBody()->getContents());

            // Clear BOM chars from response
            if (str_starts_with(bin2hex($data), 'efbbbf')) {
                $data = substr($data, 3);
            }

            $content = json_decode($data, true, 512, JSON_THROW_ON_ERROR);

            return match ($content['status']) {
                'online' => new ServiceStateDTO(ServerState::ONLINE, $content['message']),
                'starting' => new ServiceStateDTO(ServerState::STARTING, $content['message']),
                default => new ServiceStateDTO(ServerState::OFFLINE, $content['message']),
            };
        } catch (RequestException $exception) {
            return new ServiceStateDTO(ServerState::UNRESPONSIVE, $exception->getMessage());
        }
    }
}
