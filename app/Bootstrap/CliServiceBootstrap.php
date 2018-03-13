<?php

namespace App\Bootstrap;

use App\Cli;
use App\Event\DatabaseEvent;
use Nilnice\Phalcon\Constant\Service;
use Nilnice\Phalcon\Http\Request;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;
use Phalcon\Events\Manager;
use Phalcon\Mvc\Url;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class CliServiceBootstrap implements CliBootstrapInterface
{
    /**
     * @var \App\Cli $cli
     */
    private $cli;

    /**
     * @var \Phalcon\DiInterface $di
     */
    private $di;

    /**
     * @var \Phalcon\Config\Adapter\Ini $ini
     */
    private $ini;

    /**
     * Run service.
     *
     * @param \App\Cli                    $cli
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     */
    public function run(Cli $cli, DiInterface $di, Ini $ini)
    {
        $this->cli = $cli;
        $this->di = $di;
        $this->ini = $ini;

        $this->main();
    }

    protected function main() : void
    {
        $this->setConfigService();
        $this->setHttpService();
        $this->setUrlService();
        $this->setEventManagerService();
        $this->setDatabaseService();
        $this->setRabbitMQService();
    }

    /**
     * Set config service.
     */
    private function setConfigService() : void
    {
        $this->di->setShared(Service::CONFIG, function () {
            return new Ini(CONFIG_DIR . Service::CONFIG_FILE);
        });
    }

    /**
     * Set http service.
     */
    private function setHttpService() : void
    {
        $this->di->setShared(Service::REQUEST, new Request());
        $this->di->setShared(Service::RESPONSE, new Response());
    }

    /**
     * Set url service.
     */
    private function setUrlService() : void
    {
        $ini = $this->ini;
        $this->di->setShared(Service::URL, function () use ($ini) {
            $baseUri = $ini->get('application')->baseUri;

            return (new Url())->setBaseUri($baseUri);
        });
    }

    /**
     * Set event manager service.
     */
    private function setEventManagerService() : void
    {
        $this->di->setShared(Service::EVENTS_MANAGER, new Manager());
    }

    /**
     * Set database service.
     */
    private function setDatabaseService() : void
    {
        $ini = $this->ini;
        $this->di->setShared(Service::DB,
            function () use ($ini) {
                $class = 'Phalcon\Db\Adapter\Pdo\\' . $ini->database->adapter;
                $parameter = [
                    'host'     => $ini->database->host,
                    'username' => $ini->database->username,
                    'password' => $ini->database->password,
                    'dbname'   => $ini->database->dbname,
                    'charset'  => $ini->database->charset,
                    'options'  => [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                    ],
                ];

                if ($ini->database->adapter == 'Postgresql') {
                    unset($parameter['charset']);
                }

                $connection = new $class($parameter);

                if ($ini->application->isListenDb) {
                    /**
                     * Use the EventManager to listen Database executed query.
                     *
                     * @see https://docs.phalconphp.com/ar/3.2/events
                     */
                    $manager = new Manager();
                    $manager->attach(Service::DB, new DatabaseEvent());
                    $connection->setEventsManager($manager);
                }

                return $connection;
            });
    }

    /**
     * Set RabbitMQ service.
     */
    private function setRabbitMQService() : void
    {
        $ini = $this->ini;
        $this->di->setShared(Service::RABBITMQ, function () use ($ini) {
            $connection = new AMQPStreamConnection(
                $ini->rabbitmq->host,
                $ini->rabbitmq->port,
                $ini->rabbitmq->username,
                $ini->rabbitmq->password,
                $ini->rabbitmq->vhost,
                $ini->rabbitmq->insist,
                $ini->rabbitmq->loginMethod,
                $ini->rabbitmq->loginResponse,
                $ini->rabbitmq->locale
            );

            return $connection;
        });
    }
}
