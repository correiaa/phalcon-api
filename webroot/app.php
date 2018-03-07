<?php

use App\Bootstrap;
use App\Bootstrap\AppServiceBootstrap;
use App\Register;
use Dotenv\Dotenv;
use Nilnice\Phalcon\App;
use Nilnice\Phalcon\Constant\Service;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Di\FactoryDefault as Di;
use Phalcon\Loader;

require dirname(__DIR__) . '/config/paths.php';
require ROOT . '/vendor/autoload.php';

$dotenv = new Dotenv(dirname(__DIR__) . '/config', '.env');
$dotenv->load();
$env = getenv('APP_ENV');

error_reporting($env === 'pro' ? E_ALL & ~E_DEPRECATED & ~E_STRICT : E_ALL);

try {
    $di = new Di();
    $loader = new Loader();

    require APP_DIR . 'Register.php';
    $register = new Register($di, $loader);
    $register->main();

    $app = new App($di);
    $ini = new Ini(CONFIG_DIR . 'config.ini');

    $bootstrap = new Bootstrap(
        new AppServiceBootstrap(),
        new Bootstrap\MiddlewareBootstrap(),
        new Bootstrap\CollectionBootstrap()
    );
    $bootstrap->run($app, $di, $ini);
    $app->handle();

    /** @var \Nilnice\Phalcon\Http\Response $response */
    $response = $app->di->getShared(Service::RESPONSE);
    $content = $app->getReturnedValue();

    if ($content !== null) {
        if (is_string($content)) {
            $response->setContent($content);
        } else {
            $response->setJsonContent($content);
        }
    }
} catch (\Exception $e) {
    $di = $app->di ?? new Di();
    $response = $di->getShared(Service::RESPONSE);

    if (! $response || ! $response instanceof Response) {
        $response = new Response();
    }
    $devMode = $ini->application->isDebug ?: $env === 'dev';
    $response->setExceptionContent($e, $devMode);
} finally {
    if (! $response->isSent()) {
        $response->send();
    }
}
