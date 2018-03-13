<?php

namespace App\Bootstrap;

use App\Auth\UsernameAccountType;
use App\Event\DatabaseEvent;
use App\Exception\IOException;
use App\User\User;
use Nilnice\Phalcon\App;
use Nilnice\Phalcon\Auth\JWTToken;
use Nilnice\Phalcon\Auth\Manager as AuthManager;
use Nilnice\Phalcon\Constant\Service;
use Nilnice\Phalcon\Http\Request;
use Nilnice\Phalcon\Http\Response;
use Nilnice\Phalcon\Support\Message;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;
use Phalcon\Exception;
use Phalcon\Mvc\Url;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class AppServiceBootstrap implements AppBootstrapInterface
{
    /**
     * @var \Nilnice\Phalcon\App
     */
    private $app;

    /**
     * @var \Phalcon\DiInterface
     */
    private $di;

    /**
     * @var \Phalcon\Config\Adapter\Ini
     */
    private $ini;

    /**
     * Run service.
     *
     * @param \Nilnice\Phalcon\App        $app
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed|void
     * @throws \Phalcon\Exception
     */
    public function run(App $app, DiInterface $di, Ini $ini)
    {
        $this->app = $app;
        $this->di = $di;
        $this->ini = $ini;

        $this->main();
    }

    /**
     * Inject necessary services into the container.
     *
     * @throws \Phalcon\Exception
     */
    protected function main() : void
    {
        $this->setConfigService();
        $this->setUrlService();
        $this->setJWTTokenService();
        $this->setAuthManagerService();
        $this->setDatabaseService();
        $this->setUserService();
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
        $this->di->setShared(Service::MESSAGE, new Message());
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
     * Set JWT token service.
     *
     * @throws \Phalcon\Exception
     */
    private function setJWTTokenService() : void
    {
        $ini = $this->ini;
        $this->di->setShared(Service::JWT_TOKEN,
            function () use ($ini) {
                return new JWTToken(
                    $ini->get('security')->appsecret,
                    JWTToken::ALGORITHM_HS256
                );
            });
    }

    /**
     * Set auth manager service.
     */
    private function setAuthManagerService() : void
    {
        $ini = $this->ini;
        $this->di->setShared(Service::AUTH_MANAGER, function () use ($ini) {
            $expirationTime = $ini->get('security')->expirationTime;
            $authManager = new AuthManager($expirationTime);
            $authManager->registerAccountType(
                UsernameAccountType::NAME,
                new UsernameAccountType()
            );

            return $authManager;
        });
    }

    /**
     * Set database service.
     */
    private function setDatabaseService() : void
    {
        $di = $this->di;
        $ini = $this->ini;
        $this->di->setShared(Service::DB, function () use ($di, $ini) {
            $database = $ini->get('database');
            $class = 'Phalcon\Db\Adapter\Pdo\\' . $database->adapter;
            $parameter = [
                'host'     => $database->host,
                'username' => $database->username,
                'password' => $database->password,
                'dbname'   => $database->dbname,
                'charset'  => $database->charset,
                'options'  => [
                    \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
                ],
            ];

            if ($database->adapter === 'Postgresql') {
                unset($parameter['charset']);
            }

            /** @var \Phalcon\Db\Adapter\Pdo $connection */
            $connection = new $class($parameter);

            if ($ini->get('application')->isListenDb) {
                /**
                 * Use the EventManager to listen Database executed query.
                 *
                 * @var \Phalcon\Events\Manager $manager
                 * @see https://docs.phalconphp.com/ar/3.2/events
                 */
                $manager = $di->get(Service::EVENTS_MANAGER);

                try {
                    $manager->attach(Service::DB, new DatabaseEvent());
                } catch (IOException $e) {
                    echo $e->getMessage();
                }
                $connection->setEventsManager($manager);
            }

            return $connection;
        });
    }

    /**
     * Set user service.
     */
    public function setUserService() : void
    {
        $this->di->setShared(Service::USER, new User());
    }

    /**
     * Set RabbitMQ service.
     */
    private function setRabbitMQService() : void
    {
        $ini = $this->ini;
        $this->di->setShared(Service::RABBITMQ, function () use ($ini) {
            $rabbitmq = $ini->get('rabbitmq');
            $connection = new AMQPStreamConnection(
                $rabbitmq->host,
                $rabbitmq->port,
                $rabbitmq->username,
                $rabbitmq->password,
                $rabbitmq->vhost,
                $rabbitmq->insist,
                $rabbitmq->loginMethod,
                $rabbitmq->loginResponse,
                $rabbitmq->locale
            );

            return $connection;
        });
    }
}
