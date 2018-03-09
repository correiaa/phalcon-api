<?php

namespace App;

use Nilnice\Phalcon\Constant\Service;
use Phalcon\Cli\Console;

class Cli extends Console
{
    /**
     * Attach middleware.
     *
     * @param $middleware
     *
     * @return \App\Cli
     */
    public function attach($middleware) : self
    {
        if (! $this->getEventsManager()) {
            $this->setEventsManager(
                $this->getDI()->get(Service::EVENTS_MANAGER)
            );
        }

        $this->getEventsManager()->attach('micro', $middleware);

        return $this;
    }
}
