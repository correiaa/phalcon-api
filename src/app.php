<?php

/**
 * Local variables.
 *
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Home page.
 */
$app->get('/', [new \App\Controller\DefaultController(), 'indexAction']);

$app->get('/a/b', function () {
    throw new \RuntimeException('sdfaf');
});

/**
 * Default page.
 */
$app->get('/util', [new \App\Controller\DefaultController(), 'utilAction']);

/**
 * RabbitMQ producer.
 */
$app->get('/api/v1/queue/producer', [new \App\Controller\RabbitController(), 'producerAction']);

/**
 * Get user list.
 */
$app->get('/api/v1/user/list', [new \App\Controller\UserController(), 'listAction']);

/**
 * Get user entity.
 */
$app->get('/api/v1/user/{id:[a-z0-9-]+}', [new \App\Controller\UserController(), 'viewAction']);

/**
 * Get token.
 */
$app->get('/api/v1/token/get/{id:[0-9]+}/{timestamp:[0-9]+}', [new \App\Controller\TokenController(), 'getAction']);

/**
 * Not found handler.
 */
$app->notFound(function () use ($app) {
    $app->response
        ->setStatusCode(404, 'Not Found')
        ->sendHeaders()
        ->setJsonContent(
            [
                'status' => false,
                'code'   => 'API_1003',
                'msg'    => '404 Not Found',
                'tip'    => '404 Not Found',
                'data'   => [],
            ]
        );

    return $app->response;
});

/**
 * Error handler.
 */
$app->error(function ($exception) use ($app) {
    $isDebug = $app->getService('config')->application->isDebug;

    if (!$isDebug) {
        $app->response
            ->setStatusCode(200, 'Exception')
            ->sendHeaders()
            ->setJsonContent(
                [
                    'status' => false,
                    'code'   => 'API_1004',
                    'msg'    => $exception->getMessage(),
                    'tip'    => '',
                    'data'   => [],
                ]
            );

        return $app->response;
    }
});
