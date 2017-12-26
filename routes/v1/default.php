<?php

return call_user_func(function () use ($api) {
    $config = $api->getDI()->get('config');
    $version = $config->application->apiVersion;
    $prefix = "/api/{$version}/default";
    $collection = new \Phalcon\Mvc\Micro\Collection();
    $collection->setPrefix($prefix)
        ->setHandler(\app\Controller\DefaultController::class)
        ->setLazy(true);

    /** Get default page. */
    $collection->get('/get', 'getAction');

    /** Get view page . */
    $collection->get('/view', 'viewAction');

    return $collection;
});
