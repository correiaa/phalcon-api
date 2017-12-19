<?php

/**
 * CLI access main entry.
 */

use App\bak;
use Phalcon\Cli\Console;
use Phalcon\Cli\Console\Exception;
use Phalcon\Di\FactoryDefault\Cli;
use Phalcon\Loader;

error_reporting(E_ALL);

require dirname(__DIR__) . '/config/paths.php';
require ROOT . '/vendor/autoload.php';

$Cli = new Cli();

require APP_DIR . 'Bootstrap.php';
$Bootstrap = new bak($Cli, new Loader());
$Bootstrap->main();
$Console = new Console();
$Console->setDI($Cli);

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
    $Console->handle($arguments);
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
