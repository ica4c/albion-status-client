<?php

namespace Albion\Status\Decorators;

use Albion\Status\DTOs\ServiceStateDTO;
use Albion\Status\Models\State;
use DateTime;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;

class ResponseStateDTODecorator
{
    protected function isDTTime(): bool
    {
        $dtStartTime = (new DateTime('now'))->setTime(10, 00, 00, 00);
        $dtEndTime   = (new DateTime('now'))->setTime(11, 00, 00, 00);
        $now         = new DateTime();

        return $dtStartTime < $now && $now < $dtEndTime;
    }

    public function decorate(ResponseInterface $response): ServiceStateDTO
    {
        try {
            $data = trim($response->getBody()->getContents());

            // Clear BOM chars from response
            if (0 === strpos(bin2hex($data), 'efbbbf')) {
                $data = substr($data, 3);
            }

            $content = json_decode($data, true);

            switch ($content['status']) {
                case 'online':
                    return new ServiceStateDTO(State::of(State::ONLINE), $content['message']);

                case 'starting':
                    return new ServiceStateDTO(State::of(State::STARTING), $content['message']);

                default:

                    if ($this->isDTTime()) {
                        return new ServiceStateDTO(State::of(State::OFFLINE), $content['message']);
                    }

                    return new ServiceStateDTO(State::of(State::FAILED), 'Failed to resolve service state');
            }
        } catch (RequestException $exception) {
            return new ServiceStateDTO(State::of(State::UNRESPONSIVE), $exception->getMessage());
        }
    }
}