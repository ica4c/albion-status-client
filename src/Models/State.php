<?php

namespace Albion\Status\Models;

use Solid\Foundation\Enum;

class State extends Enum
{
    const OFFLINE = 'offline';
    const ONLINE = 'online';
    const STARTING = 'starting';
    const UNRESPONSIVE = 'unresponsive';
    const FAILED = 'failed';
}