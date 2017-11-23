<?php

/**
 * Local variables.
 *
 * @var \Phalcon\Mvc\Micro $app
 */

/**
 * Home page.
 */
$app->get('/', function () {
    /** @var \Phalcon\Mvc\Micro $this */
    $this->response->setStatusCode(200, 'OK')->sendHeaders();
    $result = [
        'phalcon'     => [
            'id'      => \Phalcon\Version::getId(),
            'version' => \Phalcon\Version::get(),
        ],
        'application' => [
            'clientAddress' => $this->request->getClientAddress(),
            'clientCharset' => $this->request->getClientCharsets(),
            'httpHost'      => $this->request->getHttpHost(),
            'userAgent'     => $this->request->getUserAgent(),
            'uri'           => $this->request->getURI(),
            'port'          => $this->request->getPort(),
            'scheme'        => $this->request->getScheme(),
            'method'        => $this->request->getMethod(),
            'serverName'    => $this->request->getServerName(),
            'serverAddress' => $this->request->getServerAddress(),
            'contentType'   => $this->request->getContentType(),
            'basicAuth'     => $this->request->getBasicAuth(),
            'languages'     => $this->request->getLanguages(),
        ],
    ];
    $this->response->setJsonContent($result);

    return $this->response;
});

/**
 * Default page.
 */
$app->get('/default/index', function () {
    /** @var \Phalcon\Mvc\Micro $this */
    $this->response->setStatusCode(200, 'OK')->sendHeaders();
    $this->response->setJsonContent(
        [
            'getClientAddress'               => $this->request->getClientAddress(),
            'getClientCharsets'              => $this->request->getClientCharsets(),
            'getUserAgent'                   => $this->request->getUserAgent(),
            'getHttpHost'                    => $this->request->getHttpHost(),
            'getMethods'                     => $this->request->getMethod(),
            'getHttpMethodParameterOverride' => $this->request->getHttpMethodParameterOverride(),
            'getURI'                         => $this->request->getURI(),
            'getPort'                        => $this->request->getPort(),
            'getServerName'                  => $this->request->getServerName(),
            'getServerAddress'               => $this->request->getServerAddress(),
            'getContentType'                 => $this->request->getContentType(),
            'getScheme'                      => $this->request->getScheme(),
            'getBasicAuth'                   => $this->request->getBasicAuth(),
            'getLanguages'                   => $this->request->getLanguages(),
        ]
    );
    $a = \App\Model\Users::find();
    $this->response->setJsonContent($a);

    return $this->response;
});

/**
 * RabbitMQ producer.
 */
$app->get('/api/v1/queue/producer', function () {
    /** @var \PhpAmqpLib\Connection\AMQPStreamConnection $AMQPStreamConnection */
    $AMQPStreamConnection = $this->getSharedService('rabbitmq');
    $AMQPChannel = $AMQPStreamConnection->channel();
    $AMQPChannel->queue_declare(
        'test',
        false,
        false,
        false,
        false
    );

    $AMQPMessage = new \PhpAmqpLib\Message\AMQPMessage('this is a test for RabbitMQ.');
    $AMQPChannel->basic_publish($AMQPMessage, false, 'test');
    $AMQPChannel->close();
    $AMQPStreamConnection->close();
    $this->response->setStatusCode(200, 'OK')->sendHeaders();
    $this->response->setJsonContent(
        [
            $AMQPMessage->getBody(),
            $AMQPMessage->getBodySize(),
            $AMQPMessage->getContentEncoding(),
            $AMQPMessage->get_properties(),
        ]);

    return $this->response;

});

/**
 * Get user entity by id.
 */
$app->get('/api/v1/user/{id:[a-z0-9-]+}', function ($id) {
    $object = \App\Model\Users::findFirst([
        'conditions' => 'id=:id:',
        'bind'       => [
            'id' => $id,
        ],
    ]);
    $result = $object ? $object->toArray() : [];

    /** @var $this \Phalcon\Mvc\Micro */
    $this->response->setStatusCode(200, 'OK')->sendHeaders();
    $this->response->setJsonContent($result);

    return $this->response;
});

/**
 * Get user list.
 */
$app->get('/api/v1/user/list', function () {
    $object = \App\Model\Users::find();
    $result = $object->toArray();

    /** @var $this \Phalcon\Mvc\Micro */
    $this->response->setStatusCode(200, 'OK')->sendHeaders();
    $this->response->setJsonContent($result);

    return $this->response;
});

/**
 * Not found handler.
 */
$app->notFound(function () use ($app) {
    $app->response->setStatusCode(404, 'Not Found')->sendHeaders();
    echo $app['view']->render('404');
});
