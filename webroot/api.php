<?php

use App\Bootstrap;
use App\Bootstrap\ApiServiceBootstrap;
use App\Register;
use Dotenv\Dotenv;
use Nilnice\Phalcon\Api;
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

    $api = new Api($di);
    $ini = new Ini(CONFIG_DIR . 'config.ini');

    $bootstrap = new Bootstrap(
        new ApiServiceBootstrap(),
        new Bootstrap\CollectionBootstrap()
    );
    $bootstrap->run($api, $di, $ini);
    $api->handle();

    /** @var \Nilnice\Phalcon\Http\Response $response */
    $response = $api->di->getShared(Service::RESPONSE);
    $content = $api->getReturnedValue();

    if ($content !== null) {
        if (is_string($content)) {
            $response->setContent($content);
        } else {
            $response->setJsonContent($content);
        }
    }
} catch (\Exception $e) {
    $di = $api->di ?? new Di();
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
