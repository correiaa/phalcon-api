<?php

use App\Bootstrap;
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Micro;

/**
 * Sets which PHP errors are reported.
 */
error_reporting(E_ALL);

/**
 * Use the DS to separate the directories in other defines.
 */
if ( ! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('APP', ROOT . DS . 'src' . DS);
define('CONFIG', ROOT . DS . 'config' . DS);
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);
define('TMP', ROOT . DS . 'tmp' . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);

require ROOT . '/vendor/autoload.php';

try {
    $di = new FactoryDefault();

    require APP . 'Bootstrap.php';
    $Bootstrap = new Bootstrap($di, new Loader());
    $Bootstrap->main();

    $Micro = new Micro($di);
    $config = $di->get('config');

    $di->set('collection', function () use ($Micro) {
        return include APP . 'routes/router.php';
    });
    foreach ((array)$di->get('collection') as $collection) {
        $Micro->mount($collection);
    }

    $Micro->handle();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
