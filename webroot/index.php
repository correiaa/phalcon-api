<?php

use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Micro;

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
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    include CONFIG . 'loader.php'; // Include phalcon autoloader.

    $manager = new Manager();

    /**
     * Starting the application
     * Assign service locator to the application
     */
    $app = new Micro($di);

    /**
     * Include Application
     */
    include APP . '/app.php';

    /**
     * Handle the request
     */
    $app->handle();
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
