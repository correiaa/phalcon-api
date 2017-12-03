<?php

return call_user_func(function () use ($Micro) {
    $Config = $Micro->getDI()->get('config');
    $version = $Config->application->apiVersion;
    $prefix = "/api/{$version}/rabbitmq";
    $collection = new \Phalcon\Mvc\Micro\Collection();
    $collection->setPrefix($prefix)
        ->setHandler(\App\Controller\RabbitController::class)
        ->setLazy(true);

    /**
     * RabbitMQ producer.
     */
    $collection->post('/producer', 'producerAction');

    return $collection;
});
