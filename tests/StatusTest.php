<?php

declare(strict_types=1);

namespace Tests;

use Albion\Status\Client;
use Albion\Status\Enums\RealmStatusHost;
use Albion\Status\Enums\ServerState;

class StatusTest extends MockedClientTestCase
{
    protected Client $client;

    /**
     * @return void
     *
     * @throws \JsonException
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(
            $this->mockClient(
                $this->loadResponseSamplesFromSamplesJson('status_200_responses.json')
            )
        );
    }

    /**
     * @dataProvider realmDataProvider
     *
     * @param \Albion\Status\Enums\RealmStatusHost $realm
     *
     * @return void
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function testStatusReport(RealmStatusHost $realm): void
    {
        static::assertSame(
            $this->client->getServiceStatus($realm)->getState(),
            ServerState::ONLINE
        );

        static::assertSame(
            $this->client->getServiceStatus($realm)->getState(),
            ServerState::OFFLINE
        );

        static::assertSame(
            $this->client->getServiceStatus($realm)->getState(),
            ServerState::STARTING
        );
    }

    /**
     * @return array
     */
    public function realmDataProvider(): array
    {
        return [
            [RealmStatusHost::AMERICA],
            [RealmStatusHost::ASIA],
            [RealmStatusHost::EUROPE],
        ];
    }
}