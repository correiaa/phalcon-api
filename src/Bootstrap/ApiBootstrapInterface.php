<?php

namespace App\Bootstrap;

use App\Api;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

/**
 * ApiBootstrap Interface.
 *
 * @copyright Copyright (c) Xiaohe Software Foundation, Inc.
 * @link      https://www.xiaohe.com/ Xiaohe(tm) Project
 * @package   App\Bootstrap
 * @date      2017-12-19 23:10
 * @author    majinyun <majinyun@xiaohe.com>
 */
interface ApiBootstrapInterface
{
    /**
     * Run api some services.
     *
     * @param \App\Api                    $api
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed
     */
    public function run(Api $api, DiInterface $di, Ini $ini);
}
