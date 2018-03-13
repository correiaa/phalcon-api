<?php

namespace App\Bootstrap;

use Nilnice\Phalcon\App;
use Nilnice\Phalcon\AppBootstrapInterface;
use Nilnice\Phalcon\Middleware\AuthenticationMiddleware;
use Nilnice\Phalcon\Middleware\AuthorizationMiddleware;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

class MiddlewareBootstrap implements AppBootstrapInterface
{
    /**
     * Run middleware service.
     *
     * @param \Nilnice\Phalcon\App        $app
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed|void
     */
    public function run(App $app, DiInterface $di, Ini $ini)
    {
        $app->attach(new AuthenticationMiddleware())
            ->attach(new AuthorizationMiddleware());
    }
}
