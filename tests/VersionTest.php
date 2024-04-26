<?php

declare(strict_types=1);

namespace Tests;

use Albion\Status\Client;

class VersionTest extends MockedClientTestCase
{
    protected Client $client;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->client = new Client(
            $this->mockClient([
                $this->makeSampleByResource(200, 'plain/text', 'manifest_response.txt')
            ])
        );
    }

    public function testVersion()
    {
        $report = $this->client->getClientVersion();

        $this->assertNotNull($report->getAndroid());
        $this->assertNotNull($report->getIOS());
        $this->assertNotNull($report->getLinux());
        $this->assertNotNull($report->getWindows());
        $this->assertNotNull($report->getOSX());
    }
}
