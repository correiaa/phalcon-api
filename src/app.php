<?php

/**
 * Local variables.
 *
 * @var \Phalcon\Mvc\Micro $app
 */

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
