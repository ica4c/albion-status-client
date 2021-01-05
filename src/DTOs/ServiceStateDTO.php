<?php

namespace Albion\Status\DTOs;

use Albion\Status\Models\State;

final class ServiceStateDTO
{
    /** @var \Albion\Status\Models\State */
    protected $state;
    /** @var array string */
    protected $message;

    /**
     * ServiceStateDTO constructor.
     *
     * @param \Albion\Status\Models\State $state
     * @param string|null                 $message
     */
    public function __construct(State $state, ?string $message = null)
    {
        $this->state = $state;
        $this->message = $message;
    }

    /**
     * @return \Albion\Status\Models\State
     */
    public function getState(): State
    {
        return $this->state;
    }

    /**
     * @return array
     */
    public function getMessage()
    {
        return $this->message;
    }
}