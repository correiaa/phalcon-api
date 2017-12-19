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

    /** Event manager service. */
    const EVENT_MANAGER = 'eventManager';

    /** Configuration service. */
    const CONFIG = 'config';
    const CONFIG_FILE = 'config.ini';

    /** URL service. */
    const URL = 'url';

    /** Queue service. */
    const RABBITMQ = 'rabbitmq';

    /** Database service. */
    const DB = 'db';
}
