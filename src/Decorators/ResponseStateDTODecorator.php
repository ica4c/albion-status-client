<?php

namespace Albion\Status\Decorators;

use Albion\Status\DTOs\ServiceStateDTO;
use Albion\Status\Models\State;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ResponseStateDTODecorator
{
    public function decorate(ResponseInterface $response): ServiceStateDTO {
        try {
            switch ($response->getStatusCode()) {
                case 200:
                    $data = trim($response->getBody()->getContents());

                    // Clear BOM chars from response
                    if (0 === strpos(bin2hex($data), 'efbbbf')) {
                        $data = substr($data, 3);
                    }

                    $content = json_decode($data, true);

                    switch ($content['status']) {
                        case 'online':
                            return new ServiceStateDTO(State::of(State::ONLINE), $content['message']);

                        case 'offline':
                            return new ServiceStateDTO(State::of(State::OFFLINE), $content['message']);

                        case 'starting':
                            return new ServiceStateDTO(State::of(State::STARTING), $content['message']);

                        default:
                            return new ServiceStateDTO(State::of(State::FAILED), 'Failed to resolve service state');
                    }

                case 500:
                default:
                    return new ServiceStateDTO(State::of(State::UNRESPONSIVE), $response->getReasonPhrase());
            }
        } catch (RequestException $exception) {
            return new ServiceStateDTO(State::of(State::UNRESPONSIVE), $exception->getMessage());
        }
    }
}