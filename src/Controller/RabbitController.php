<?php

namespace App\Controller;

use PhpAmqpLib\Message\AMQPMessage;

/**
 * Rabbit Controller.
 *
 * @package App\Controller
 */
class RabbitController extends AbstractController
{
    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function producerAction()
    {
        $data = $this->request->getPost('data');
        $name = isset($data['name']) ? $data['name'] : 'testing_queue';
        $text = isset($data['text']) ? $data['text'] : ': ) RabbitMQ test.';

        /** @var \PhpAmqpLib\Connection\AMQPStreamConnection $AMQPStreamConnection */
        $AMQPStreamConnection = $this->getDI()->getShared('rabbitmq');
        $AMQPChannel = $AMQPStreamConnection->channel();
        $AMQPChannel->queue_declare(
            $name,
            false,
            true,
            false,
            false
        );
        $message = ['text' => $text];
        $message = json_encode($message);

        /** @var AMQPMessage $AMQPMessage */
        $AMQPMessage = new AMQPMessage($message);
        $AMQPChannel->basic_publish($AMQPMessage, '', $name);
        logger(json_encode($text), 8, 'producer');
        $AMQPChannel->close();
        $AMQPStreamConnection->close();
        $this->response->setStatusCode(200, 'OK')->sendHeaders();
        $this->response->setJsonContent(
            [
                '队列内容' => $AMQPMessage->getBody(),
                '内容大小' => $AMQPMessage->getBodySize(),
            ]
        );

        return $this->response;
    }
}

