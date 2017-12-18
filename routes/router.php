<?php

/**
 * User all routes collection.
 */
$function = call_user_func(function () use ($Micro) {
    $Config = $Micro->getDI()->get('config');
    $version = $Config->application->apiVersion;
    $directory = __DIR__ . DS . $version . DS;

    if ( ! file_exists($directory)) {
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

$Micro->get('/', function () use ($Micro) {
    $Micro->response
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

    return $Micro->response;
});

/**
 * Not found handler.
 */
$Micro->notFound(function () use ($Micro) {
    $Micro->response
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

    return $Micro->response;
});

/**
 * Error handler.
 */
$Micro->error(function ($exception) use ($Micro) {
    $isDebug = $Micro->getDI()->get('config')->application->isDebug;

    if ( ! $isDebug) {
        $Micro->response
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

        return $Micro->response;
    }
});

return $function;
