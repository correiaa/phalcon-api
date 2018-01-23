<?php

/**
 * Use the DS to separate the directories in other defines.
 */
if (! defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}

/**
 * The full path to the directory which holds "src", without a trailing DS.
 */
define('ROOT', dirname(__DIR__));

/**
 * Path to the application's directory.
 */
define('APP_DIR', ROOT . DS . 'app' . DS);

/**
 * Path to the config directory.
 */
define('CONFIG_DIR', ROOT . DS . 'config' . DS);

/**
 * Path to the routes directory.
 */
define('ROUTE_DIR', ROOT . DS . 'routes' . DS);

/**
 * File path to the webroot directory.
 */
define('WWW_DIR', ROOT . DS . 'webroot' . DS);

/**
 * Path to the temporary files directory.
 */
define('TMP_DIR', ROOT . DS . 'tmp' . DS);

/**
 * Path to the logs directory.
 */
define('LOGS_DIR', TMP_DIR . 'logs' . DS);

/**
 * Path to the cache files directory. It can be shared between hosts in a
 * multi-server setup.
 */
define('CACHE_DIR', TMP_DIR . 'cache' . DS);
