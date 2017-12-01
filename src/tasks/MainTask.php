<?php

namespace App\Task;

use Phalcon\Cli\Task;

/**
 * Main Task.
 *
 * @package App\Task
 */
class MainTask extends Task
{
    public function mainAction()
    {
        echo ' [x] ' . __METHOD__ . PHP_EOL;
    }
}
