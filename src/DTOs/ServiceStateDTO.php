<?php

declare(strict_types=1);

namespace Albion\Status\DTOs;

use Albion\Status\Enums\ServerState;

final class ServiceStateDTO
{
    public function __construct(
        protected ServerState $state,
        protected ?string $message = null
    ) {
    }

    public function getState(): ServerState
    {
        return $this->state;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
