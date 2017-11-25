<?php

namespace App\Controller;

use Phalcon\Mvc\Controller;
use PhpAmqpLib\Message\AMQPMessage;

/**
 * Rabbit Controller.
 *
 * @package App\Controller
 */
class RabbitController extends Controller
{
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function producerAction()
    {
        $AMQPStreamConnection = $this->getSharedService('rabbitmq');
        $AMQPChannel = $AMQPStreamConnection->channel();
        $AMQPChannel->queue_declare(
            'test',
            false,
            false,
            false,
            false
        );

        $AMQPMessage = new AMQPMessage('this is a test for RabbitMQ.');
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
    }
}

