<?php

namespace App;

use Phalcon\Cli\Console;

class Cli extends Console
{
    /**
     * Attach middleware.
     *
     * @param object $middleware
     *
     * @return $this
     */
    public function attach($middleware)
    {
        if (! $this->getEventsManager()) {
            $this->setEventsManager(
                $this->getDI()->get(Service::EVENT_MANAGER)
            );
        }

        $this->getEventsManager()->attach('micro', $middleware);

        return $this;
    }
}
