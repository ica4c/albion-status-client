<?php

namespace Tests;

use Albion\Status\Client;
use Albion\Status\Models\State;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    /** @var \Albion\Status\Client */
    protected $client;

    /**
     * TestStatus constructor.
     */
    public function __construct()
    {
        parent::__construct('Client test case');
        $this->client = new Client();
    }


    public function testStatusReport(): void
    {
        $report = $this->client->getServiceStatus();

        static::assertTrue(
            $report->getState()->is(State::ONLINE) ||
            $report->getState()->is(State::OFFLINE) ||
            $report->getState()->is(State::STARTING)
        );
    }

    public function testMaintenanceReport(): void
    {
        $report = $this->client->getMaintenanceStatus();

        static::assertTrue(
            $report->getState()->is(State::ONLINE) ||
            $report->getState()->is(State::OFFLINE) ||
            $report->getState()->is(State::STARTING)
        );
    }
}