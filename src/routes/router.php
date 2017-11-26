<?php

/**
 * User all routes collection.
 */
$function = call_user_func(function () use ($config) {
    $version = $config->application->apiVersion;
    $directory = __DIR__ . DS . $version . DS;

    if (!file_exists($directory)) {
        throw new \ErrorException("$version directory is not exists.");
    }

    $collections = [];
    $files = scandir($directory, SCANDIR_SORT_ASCENDING);
    if (count($files)) {
        foreach ($files as $file) {
            $info = pathinfo($file);
            if ($info['extension'] === 'php') {
                $collections[] = include "{$directory}{$file}";
            }
        }
    }

    return $collections;
});

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


return $function;
