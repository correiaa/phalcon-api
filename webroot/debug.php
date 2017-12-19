<?php

use App\bak;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Micro;

/**
 * Sets which PHP errors are reported.
 */
error_reporting(E_ALL);

require dirname(__DIR__) . '/config/paths.php';
require ROOT . '/vendor/autoload.php';

try {
    $di = new FactoryDefault();

    require APP_DIR . 'Bootstrap.php';
    $Bootstrap = new bak($di, new Loader());
    $Bootstrap->main();

    $Micro = new Micro($di);
    $config = $di->get('config');

    $di->set('collection', function () use ($Micro) {
        return include ROUTE_DIR . '/router.php';
    });
    foreach ((array)$di->get('collection') as $collection) {
        $Micro->mount($collection);
    }

    $Micro->handle();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
