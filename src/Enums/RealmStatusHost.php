<?php

declare(strict_types=1);

namespace Albion\Status\Enums;

enum RealmStatusHost: string
{
    case AMERICA = 'https://serverstatus.albiononline.com';
    case ASIA = 'https://serverstatus-sgp.albiononline.com';
    case EUROPE = 'https://serverstatus-ams.albiononline.com';
}
