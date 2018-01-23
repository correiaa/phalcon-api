<?php

return call_user_func(function () use ($api) {
    $config = $api->getDI()->get('config');
    $version = $config->application->apiVersion;
    $prefix = "/api/{$version}/user";
    $collection = new \Phalcon\Mvc\Micro\Collection();
    $collection->setPrefix($prefix)
               ->setHandler(\App\Controller\UserController::class)
               ->setLazy(true);

    /** Add user. */
    $collection->post('/add', 'addAction');

    /** Set user. */
    $collection->post('/set', 'setAction');

    /** Get user. */
    $collection->get('/get/{id:[a-z0-9-_]+}', 'getAction');

    /** Del user. */
    $collection->post('/del/{id:[a-z0-9-_]+}', 'delAction');

    /** User list. */
    $collection->get('/list', 'listAction');

    /** User */
    $collection->post('/authenticate', 'authenticateAction');

    return $collection;
});
