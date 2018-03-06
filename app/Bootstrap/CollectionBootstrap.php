<?php

namespace App\Bootstrap;

use App\Resource\UserResource;
use Nilnice\Phalcon\Api;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

class CollectionBootstrap implements ApiBootstrapInterface
{
    /**
     * Run collection.
     *
     * @param \Nilnice\Phalcon\Api        $api
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed|void
     */
    public function run(Api $api, DiInterface $di, Ini $ini)
    {
        $userResource = new UserResource('/api/v1/user');
        $api->setCollection($userResource);
    }
}
