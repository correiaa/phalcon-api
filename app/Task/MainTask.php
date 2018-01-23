<?php

namespace App\Task;

use Phalcon\Cli\Task;

class MainTask extends Task
{
    public function mainAction()
    {
        echo ' [x] ' . __METHOD__ . '.' . PHP_EOL;
        echo ' [x] This is the main task and the main action.' . PHP_EOL;
    }
}
