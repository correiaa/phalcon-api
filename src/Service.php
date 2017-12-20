<?php

namespace App;

/**
 * Service Class.
 *
 * @package App
 */
class Service
{
    /** Http service. */
    const REQUEST = 'request';
    const RESPONSE = 'response';

    /** Configuration service. */
    const CONFIG = 'config';
    const CONFIG_FILE = 'config.ini';

    /** URL service. */
    const URL = 'url';

    /** Events manager service. */
    const EVENTS_MANAGER = 'eventsManager';

    /** Auth manager service. */
    const AUTH_MANAGER = 'authManager';

    /** Token service. */
    const TOKEN = 'token';

    /** Queue service. */
    const RABBITMQ = 'rabbitmq';

    /** Database service. */
    const DB = 'db';
}
