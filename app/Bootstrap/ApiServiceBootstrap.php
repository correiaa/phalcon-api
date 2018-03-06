<?php

namespace App\Bootstrap;

use App\Auth\Manager as AuthManager;
use App\Auth\JWTToken;
use App\Auth\UsernameAccountType;
use App\Event\DatabaseEvent;
use App\Exception\IOException;
use Nilnice\Phalcon\Api;
use Nilnice\Phalcon\Constant\Service;
use Nilnice\Phalcon\Http\Request;
use Nilnice\Phalcon\Http\Response;
use Nilnice\Phalcon\Support\Message;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;
use Phalcon\Exception;
use Phalcon\Mvc\Url;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ApiServiceBootstrap implements ApiBootstrapInterface
{
    /**
     * @var \Nilnice\Phalcon\Api
     */
    private $api;

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
     * @param \Nilnice\Phalcon\Api        $api
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @throws \Phalcon\Exception
     */
    public function run(Api $api, DiInterface $di, Ini $ini)
    {
        $this->api = $api;
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
        $this->setHttpService();
        $this->setUrlService();
        $this->setJWTTokenService();
        $this->setAuthManagerService();
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
        $this->di->setShared(Service::MESSAGE, new Message());
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
            $baseUri = $ini->application->baseUri;

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
                    $ini->security->appsecret,
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
            $authManager = new AuthManager($ini->security->expirationTime);
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
