<?php

namespace App\Bootstrap;

use Nilnice\Phalcon\App;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

interface ApiBootstrapInterface
{
    /**
     * Run api some services.
     *
     * @param \Nilnice\Phalcon\App        $app
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed
     */
    public function run(App $app, DiInterface $di, Ini $ini);
}
