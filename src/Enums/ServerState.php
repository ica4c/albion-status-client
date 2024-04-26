<?php

declare(strict_types=1);

namespace Albion\Status\Enums;

enum ServerState: string
{
    case OFFLINE = 'offline';
    case ONLINE = 'online';
    case STARTING = 'starting';
    case UNRESPONSIVE = 'unresponsive';
    case FAILED = 'failed';
}
