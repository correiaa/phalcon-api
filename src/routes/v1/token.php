<?php

return call_user_func(function () use ($Micro) {
    $Config = $Micro->getDI()->get('config');
    $version = $Config->application->apiVersion;
    $prefix = "/api/{$version}/token";
    $collection = new \Phalcon\Mvc\Micro\Collection();
    $collection->setPrefix($prefix)
        ->setHandler(\App\Controller\TokenController::class)
        ->setLazy(true);

    /** Set token. */
    $collection->post('/set', 'setAction');

    /** Get token. */
    $collection->post('/get', 'getAction');

    /** Verify token. */
    $collection->get('/verify', 'verifyAction');

    /** Del token. */
    $collection->post('/del', 'delAction');

    return $collection;
});
