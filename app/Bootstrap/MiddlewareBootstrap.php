<?php

namespace App\Bootstrap;

use App\Api;
use App\Middleware\AuthenticationMiddleware;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

class MiddlewareBootstrap implements ApiBootstrapInterface
{
    /**
     * Run middleware.
     *
     * @param \App\Api                    $api
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed|void
     */
    public function run(Api $api, DiInterface $di, Ini $ini)
    {
        $api->attach(new AuthenticationMiddleware());
    }
}
