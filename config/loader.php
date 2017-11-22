<?php

/**
 * Registering an autoloader.
 */
$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
    [
        'App\\Component'  => '../src/components',
        'App\\Controller' => '../src/controllers',
        'App\\Event'      => '../src/events',
        'App\\Model'      => '../src/models',
        'App\\Traits'     => '../src/traits',
    ]
);
$loader->registerDirs(
    [
        $config->application->componentsDir,
        $config->application->controllersDir,
        $config->application->eventsDir,
        $config->application->modelsDir,
        $config->application->traitsDir,
    ]
)->register();
