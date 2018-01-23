<?php

/**
 * User all routes collection.
 */
$function = call_user_func(function () use ($api) {
    $ini = $api->getDI()->get('config');
    $version = $ini->application->apiVersion;
    $directory = __DIR__ . DS . $version . DS;

    if (! file_exists($directory)) {
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

$api->get('/', function () use ($api) {
    $api->response
        ->setStatusCode(200, 'OK')
        ->sendHeaders()
        ->setJsonContent(
            [
                'status' => true,
                'code'   => 'API_1001',
                'msg'    => 'Welcome access to the RESTful API.',
                'tip'    => '欢迎访问 RESTful API.',
                'data'   => [],
            ]
        );

    return $api->response;
});

/**
 * Not found handler.
 */
$api->notFound(function () use ($api) {
    $api->response
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

    return $api->response;
});

/**
 * Error handler.
 */
$api->error(function ($exception) use ($api) {
    $isDebug = $api->getDI()->get('config')->application->isDebug;

    if (! $isDebug) {
        $api->response
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

        return $api->response;
    }
});

return $function;
