<?php

/**
 * Shared configuration service.
 */
$di->setShared('config', function () {
    return new \Phalcon\Config\Adapter\Ini(CONFIG . 'config.ini');
});

/**
 * The URL component is used to generate all kind of urls in the application.
 */
$di->setShared('url', function () {
    $config = $this->getConfig();

    $url = new \Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file.
 */
$di->setShared('db', function () {
    $config = $this->getConfig();

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $config->database->adapter;
    $parameter = [
        'host'     => $config->database->host,
        'username' => $config->database->username,
        'password' => $config->database->password,
        'dbname'   => $config->database->dbname,
        'charset'  => $config->database->charset,
        'options'  => [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
        ],
    ];

    if ($config->database->adapter == 'Postgresql') {
        unset($parameter['charset']);
    }

    $connection = new $class($parameter);

    if ($config->application->isListenDb) {
        /**
         * Use the EventManager to listen Database executed query.
         *
         * @see https://docs.phalconphp.com/ar/3.2/events
         */
        $manager = new \Phalcon\Events\Manager();
        $manager->attach('db', new \App\Event\DatabaseEvent());
        $connection->setEventsManager($manager);
    }

    return $connection;
});

/**
 * Shared RabbitMQ service.
 */
$di->setShared('rabbitmq', function () {
    $config = $this->getConfig();

    $connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
        $config->rabbitmq->host,
        $config->rabbitmq->port,
        $config->rabbitmq->username,
        $config->rabbitmq->password,
        $config->rabbitmq->vhost,
        $config->rabbitmq->insist,
        $config->rabbitmq->loginMethod,
        $config->rabbitmq->loginResponse,
        $config->rabbitmq->locale
    );

    return $connection;
});
