<?php

namespace Tests;

use Albion\Status\Client;
use Albion\Status\Models\State;
use PHPUnit\Framework\TestCase;

class VersionTest extends TestCase
{
    /** @var \Albion\Status\Client */
    protected $client;

    public function __construct()
    {
        parent::__construct('Version test case');
        $this->client = new Client();
    }

    public function testVersion() {
        $report = $this->client->getClientVersion();

        $this->assertNotNull($report->getAndroid());
        $this->assertNotNull($report->getIOS());
        $this->assertNotNull($report->getLinux());
        $this->assertNotNull($report->getWindows());
        $this->assertNotNull($report->getOSX());
    }
}