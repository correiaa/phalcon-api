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

    /** URL service. */
    const URL = 'url';

    /** Queue service. */
    const RABBITMQ = 'rabbitmq';

    /** Database service. */
    const DB = 'db';
}
