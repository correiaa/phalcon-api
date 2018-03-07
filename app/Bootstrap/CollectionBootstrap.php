<?php

namespace App\Bootstrap;

use App\Resource\DefaultResource;
use App\Resource\UserResource;
use Nilnice\Phalcon\App;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

class CollectionBootstrap implements ApiBootstrapInterface
{
    /**
     * Run collection.
     *
     * @param \Nilnice\Phalcon\App        $app
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed|void
     */
    public function run(App $app, DiInterface $di, Ini $ini)
    {
        $app->setCollection(new DefaultResource('/'))
            ->setCollection(new UserResource('/api/v1/user'));

        self::notFoundHandler($app);
        self::errorHandler($app);
    }

    public static function notFoundHandler(App $app) : void
    {
        $app->notFound(function () use ($app) {
            return $app->response
                ->setStatusCode(404, 'Not Found')
                ->sendHeaders()
                ->setJsonContent([
                    'code'    => 404404,
                    'message' => '404 Not Found.',
                    'data'    => [],
                ]);
        });
    }

    public static function errorHandler(App $app) : void
    {
        $app->error(function () use ($app) {
            return $app->response
                ->setStatusCode(400, 'Bad Request')
                ->sendHeaders()
                ->setJsonContent([
                    'code'    => 400400,
                    'message' => '400 Bad Request.',
                    'data'    => [],
                ]);
        });
    }
}
