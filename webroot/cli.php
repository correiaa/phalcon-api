<?php

/**
 * CLI access main entry.
 */

use App\Bootstrap;
use App\Bootstrap\CliServiceBootstrap;
use App\Cli;
use App\Register;
use Phalcon\Cli\Console\Exception;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Di\FactoryDefault\Cli as Di;
use Phalcon\Loader;

error_reporting(E_ALL);

require dirname(__DIR__) . '/config/paths.php';
require ROOT . '/vendor/autoload.php';

$di = new Di();
$loader = new Loader();
$ini = new Ini(CONFIG_DIR . 'config.ini');

require APP_DIR . 'Register.php';
$register = new Register($di, $loader);
$register->main();

$cli = new Cli();
$cli->setDI($di);

$bootstrap = new Bootstrap(
    new CliServiceBootstrap()
);
$bootstrap->run($cli, $di, $ini);

/**
 * Process the console arguments.
 */
$arguments = [];
foreach ($argv as $key => $item) {
    if ($key === 1 || $key === 0) {
        $item = false !== strpos($item, 'cli') ? 'main' : $item;
        $arguments['task'] = 'App\\Task\\' . ucfirst($item);
    } elseif ($key === 2) {
        $arguments['action'] = $item;
    } elseif ($key >= 3) {
        $arguments['args'][] = $item;
    }
}

try {
    $cli->handle($arguments);
} catch (Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(1);
} catch (\Throwable $throwable) {
    exit(json_encode($throwable));
    fwrite(STDERR, $throwable->getMessage() . PHP_EOL);
    exit(2);
} catch (\Exception $exception) {
    fwrite(STDERR, $exception->getMessage() . PHP_EOL);
    exit(3);
}
