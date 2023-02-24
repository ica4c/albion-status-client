<?php

namespace Tests;

use Albion\Status\Client;
use Albion\Status\Enums\RealmStatusHost;
use Albion\Status\Models\State;
use PHPUnit\Framework\TestCase;

class StatusTest extends TestCase
{
    /** @var \Albion\Status\Client */
    protected $client;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->client = new Client();
    }

    /**
     * @param string $realm
     * @return void
     * @throws \Solid\Foundation\Exceptions\InvalidEnumValueException
     * @dataProvider realmDataProvider
     */
    public function testStatusReport(string $realm): void
    {
        $report = $this->client->getServiceStatus(RealmStatusHost::of($realm));

        static::assertTrue(
            $report->getState()->is(State::ONLINE) ||
            $report->getState()->is(State::OFFLINE) ||
            $report->getState()->is(State::STARTING)
        );
    }

    /**
     * @return array
     */
    public function realmDataProvider(): array
    {
        return [
            RealmStatusHost::WEST,
            RealmStatusHost::EAST
        ];
    }
}