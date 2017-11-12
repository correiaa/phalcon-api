<?php

/**
 * Registering an autoloader.
 */
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'App\\Model'      => '../src/models',
        'App\\Controller' => '../src/controllers',
    ]
);
$loader->registerDirs(
    [
        $config->application->modelsDir,
        $config->application->controllersDir,
    ]
)->register();
