<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;

/**
 * Sets which PHP errors are reported.
 */
error_reporting(E_ALL);

/**
 * Use the DS to separate the directories in other defines.
 */
if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
define('ROOT', dirname(__DIR__));
define('APP', ROOT . DS . 'src' . DS);
define('CONFIG', ROOT . DS . 'config' . DS);
define('WWW_ROOT', ROOT . DS . 'webroot' . DS);
define('TMP', ROOT . DS . 'tmp' . DS);
define('LOGS', TMP . 'logs' . DS);
define('CACHE', TMP . 'cache' . DS);

require CONFIG . 'helper.php';
require ROOT . '/vendor/autoload.php';

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     * These default services can be overidden with custom ones.
     */
    $di = new FactoryDefault();

    include CONFIG . 'services.php'; // Include some services.

    /**
     * Get config service for use in inline setup below.
     */
    $config = $di->getConfig();

    include CONFIG . 'loader.php'; // Include phalcon autoloader.

    $manager = new Manager();

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    $di->set('collection', function () use ($config, $app) {
        return include APP . 'routes/router.php';
    });
    foreach ((array)$di->get('collection') as $collection) {
        $app->mount($collection);
    }

    $app->handle(); // Handle the request.
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
