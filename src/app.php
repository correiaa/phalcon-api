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
 * Not found handler.
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, 'Not Found')->sendHeaders();
    $app->response->setJsonContent([
        'status' => false,
        'code'   => 'API_1004',
        'msg'    => '404 Not Found',
        'tip'    => '404 Not Found',
        'data'   => [],
    ]);

    return $app->response;
});
