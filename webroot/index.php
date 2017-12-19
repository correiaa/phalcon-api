<?php

/**
 * Web access main entry.
 */

use App\Api;
use App\Bootstrap;
use App\Bootstrap\ServiceBootstrap;
use App\Register;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

error_reporting(E_ALL);

require dirname(__DIR__) . '/config/paths.php';
require ROOT . '/vendor/autoload.php';

try {
    $di = new FactoryDefault();
    $loader = new Loader();

    require APP_DIR . 'Register.php';
    $register = new Register($di, $loader);
    $register->main();

    $api = new Api($di);
    $ini = new Ini(CONFIG_DIR . 'config.ini');

    $bootstrap = new Bootstrap(
        new ServiceBootstrap()
    );
    $bootstrap->run($api, $di, $ini);
    // require APP_DIR . 'Bootstrap.php';
    // $Bootstrap = new bak($di, new Loader());
    // $Bootstrap->main();

    $di->set('collection', function () use ($api) {
        return include ROUTE_DIR . 'router.php';
    });
    foreach ((array)$di->get('collection') as $collection) {
        $api->mount($collection);
    }

    $api->handle();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
