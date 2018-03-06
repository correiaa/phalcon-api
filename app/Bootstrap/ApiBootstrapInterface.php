<?php

namespace App\Bootstrap;

use Nilnice\Phalcon\Api;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

interface ApiBootstrapInterface
{
    /**
     * Run api some services.
     *
     * @param \Nilnice\Phalcon\Api        $api
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed
     */
    public function run(Api $api, DiInterface $di, Ini $ini);
}
