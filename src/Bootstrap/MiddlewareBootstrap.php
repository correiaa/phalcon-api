<?php

namespace App\Bootstrap;

use App\Api;
use App\Middleware\AuthenticationMiddleware;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

/**
 * MiddlewareBootstrap Class.
 *
 * @copyright Copyright (c) Xiaohe Software Foundation, Inc.
 * @link      https://www.xiaohe.com/ Xiaohe(tm) Project
 * @package   App\Bootstrap
 * @date      2017-12-20 20:59
 * @author    majinyun <majinyun@xiaohe.com>
 */
class MiddlewareBootstrap implements ApiBootstrapInterface
{
    public function run(Api $api, DiInterface $di, Ini $ini)
    {
        $api->attach(new AuthenticationMiddleware());
    }
}
