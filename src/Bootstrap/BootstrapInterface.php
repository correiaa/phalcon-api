<?php

namespace App\Bootstrap;

use App\Api;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

/**
 * Bootstrap Interface.
 *
 * @package App\Bootstrap
 */
interface BootstrapInterface
{
    /**
     * Run some services.
     *
     * @param \App\Api                    $api
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed
     */
    public function run(Api $api, DiInterface $di, Ini $ini);
}
