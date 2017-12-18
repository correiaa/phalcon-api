<?php

namespace App;

use App\Event\DatabaseEvent;
use App\Http\Request;
use App\Http\Response;
use Phalcon\Config\Adapter\Ini;
use Phalcon\Di\FactoryDefault;
use Phalcon\Events\Manager;
use Phalcon\Loader;
use Phalcon\Mvc\Url;
use PhpAmqpLib\Connection\AMQPStreamConnection;

/**
 * Bootstrap Class.
 *
 * @package App
 */
class Bootstrap
{
    /** @var \Phalcon\Di\FactoryDefault $factoryDefault */
    private $factoryDefault;

    /** @var \Phalcon\Loader $loader */
    private $loader;

    /**
     * Bootstrap constructor.
     *
     * @param \Phalcon\Di\FactoryDefault $factoryDefault
     * @param \Phalcon\Loader            $loader
     */
    public function __construct(FactoryDefault $factoryDefault, Loader $loader)
    {
        $this->factoryDefault = $factoryDefault;
        $this->loader = $loader;
    }

    /**
     * Main bootstrap entry.
     */
    public function main()
    {
        $this->registerFiles();
        $this->registerNamespaces();
        $this->registerDirs();
        $this->registerServices();
    }

    /**
     * Register directories.
     */
    protected function registerDirs()
    {
        // $config = $this->getConfigService();
        // $directories = [
        //     $config->application->componentsDir,
        //     $config->application->controllersDir,
        //     $config->application->eventsDir,
        //     $config->application->httpsDir,
        //     $config->application->middlewaresDir,
        //     $config->application->modelsDir,
        //     $config->application->tasksDir,
        //     $config->application->traitsDir,
        //     $config->application->validationsDir,
        // ];
        $directories = [APP_DIR];
        $this->loader->registerDirs($directories);
        $this->loader->register();
    }

    /**
     * Register namespaces.
     */
    protected function registerNamespaces()
    {
        $namespaces = ['App' => APP_DIR];
        $this->loader->registerNamespaces($namespaces);
        $this->loader->register();
    }

    /**
     * Register files.
     */
    protected function registerFiles()
    {
        $files = [
            CONFIG_DIR . 'helper.php',
        ];
        $this->loader->registerFiles($files);
        $this->loader->register();
    }

    /**
     * Register services.
     */
    protected function registerServices()
    {
        $this->setHttpService();
        $this->setConfigService();
        $this->setUrlService();
        $this->setDatabaseService();
        $this->setRabbitMQService();
    }

    /**
     * Set http service.
     */
    private function setHttpService()
    {
        $this->factoryDefault->setShared(Service::REQUEST, new Request());
        $this->factoryDefault->setShared(Service::RESPONSE, new Response());
    }

    /**
     * Set config service.
     */
    private function setConfigService()
    {
        $this->factoryDefault->setShared(Service::CONFIG, function () {
            return new Ini(CONFIG_DIR . 'config.ini');
        });
    }

    /**
     * Get config service.
     *
     * @return \Phalcon\Di\ServiceInterface
     */
    public function getConfigService()
    {
        return $this->factoryDefault->get(Service::CONFIG);
    }

    /**
     * Set url service.
     */
    private function setUrlService()
    {
        $Config = $this->getConfigService();
        $this->factoryDefault->setShared(Service::URL,
            function () use ($Config) {
                $baseUri = $Config->application->baseUri;

                return (new Url())->setBaseUri($baseUri);
            });
    }

    /**
     * Set database service.
     */
    private function setDatabaseService()
    {
        $Config = $this->getConfigService();
        $this->factoryDefault->setShared(Service::DB,
            function () use ($Config) {
                $class = 'Phalcon\Db\Adapter\Pdo\\'
                    . $Config->database->adapter;
                $parameter = [
                    'host'     => $Config->database->host,
                    'username' => $Config->database->username,
                    'password' => $Config->database->password,
                    'dbname'   => $Config->database->dbname,
                    'charset'  => $Config->database->charset,
                    'options'  => [
                        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                    ],
                ];

                if ($Config->database->adapter == 'Postgresql') {
                    unset($parameter['charset']);
                }

                $connection = new $class($parameter);

                if ($Config->application->isListenDb) {
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
    private function setRabbitMQService()
    {
        $Config = $this->getConfigService();
        $this->factoryDefault->setShared(Service::RABBITMQ,
            function () use ($Config) {
                $connection = new AMQPStreamConnection(
                    $Config->rabbitmq->host,
                    $Config->rabbitmq->port,
                    $Config->rabbitmq->username,
                    $Config->rabbitmq->password,
                    $Config->rabbitmq->vhost,
                    $Config->rabbitmq->insist,
                    $Config->rabbitmq->loginMethod,
                    $Config->rabbitmq->loginResponse,
                    $Config->rabbitmq->locale
                );

                return $connection;
            });
    }
}
