<?php

return call_user_func(function () use ($Micro) {
    $Config = $Micro->getDI()->get('config');
    $version = $Config->application->apiVersion;
    $prefix = "/api/{$version}/default";
    $collection = new \Phalcon\Mvc\Micro\Collection();
    $collection->setPrefix($prefix)
        ->setHandler(\App\Controller\DefaultController::class)
        ->setLazy(true);

    /** Get default page. */
    $collection->get('/get', 'getAction');

    /** Get view page . */
    $collection->get('/view', 'viewAction');

    return $collection;
});
