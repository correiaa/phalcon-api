<?php

namespace App\Controller;

use PhpAmqpLib\Message\AMQPMessage;

class RabbitController extends AbstractController
{
    /**
     * RabbitMQ producer.
     *
     * @return \Nilnice\Phalcon\Http\Response
     *
     * @throws \RuntimeException
     */
    public function producerAction()
    {
        $data = $this->request->getPost('data');
        $name = $data['name'] ?? 'testing_queue';
        $text = $data['text'] ?? ': ) RabbitMQ test.';

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

        $result = [
            '队列内容' => $AMQPMessage->getBody(),
            '内容大小' => $AMQPMessage->getBodySize(),
        ];

        return $this->successResponse($result);
    }
}

