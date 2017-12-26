<?php

return call_user_func(function () use ($api) {
    $config = $api->getDI()->get('config');
    $version = $config->application->apiVersion;
    $prefix = "/api/{$version}/rabbit";
    $collection = new \Phalcon\Mvc\Micro\Collection();
    $collection->setPrefix($prefix)
        ->setHandler(\app\Controller\RabbitController::class)
        ->setLazy(true);

    /**
     * RabbitMQ producer.
     */
    $collection->post('/producer', 'producerAction');

    return $collection;
});
