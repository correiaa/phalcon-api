<?php

namespace App;

class Service
{
    /** Http service. */
    public const REQUEST = 'request';
    public const RESPONSE = 'response';

    /** Configuration service. */
    public const CONFIG = 'config';
    public const CONFIG_FILE = 'config.ini';

    /** Security service. */
    public const SECURITY = 'security';

    /** URL service. */
    public const URL = 'url';

    /** Events manager service. */
    public const EVENTS_MANAGER = 'eventsManager';

    /** Auth manager service. */
    public const AUTH_MANAGER = 'authManager';

    /** JWT Token service. */
    public const JWT_TOKEN = 'jwtToken';

    /** Queue service. */
    public const RABBITMQ = 'rabbitmq';

    /** Database service. */
    public const DB = 'db';
}
