<?php

namespace App\Task;

use Phalcon\Cli\Task;

class QueueTask extends Task
{
    public function mainAction()
    {
        $name = 'testing_queue'; // Declare the queue name.
        $text = 'text';

        /** @var \PhpAmqpLib\Connection\AMQPStreamConnection $AMQPStreamConnection */
        $AMQPStreamConnection = $this->getDI()->get('rabbitmq');
        $AMQPChannel = $AMQPStreamConnection->channel();
        $AMQPChannel->queue_declare(
            $name,
            false,
            true,
            false,
            false
        );

        echo ' [*] Waiting for messages. To exit press CTRL+C', PHP_EOL;

        $callback = function ($msg) use ($text) {
            logger($msg->body, 8, 'consumer');
            $body = json_decode($msg->body, true);
            sleep(1);
            echo ' [x] 😀 ', $body[$text], PHP_EOL;
            echo ' [x] 🙏 ', PHP_EOL;
            $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
        };

        $AMQPChannel->basic_qos(null, 1, null);
        $AMQPChannel->basic_consume(
            $name,
            '',
            false,
            false,
            false,
            false,
            $callback
        );

        while (count($AMQPChannel->callbacks)) {
            $AMQPChannel->wait();
        }
        $AMQPChannel->close();
        $AMQPStreamConnection->close();
    }
}
