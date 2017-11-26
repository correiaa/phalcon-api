<?php

/**
 * User collection routes.
 */
return call_user_func(function () use ($config) {
    $version = $config->application->apiVersion;
    $directory = __DIR__ . DS . $version . DS;
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
