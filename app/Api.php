<?php

namespace App;

use Phalcon\Mvc\Micro;

class Api extends Micro
{
    /**
     * Attach middleware.
     *
     * @param mixed $middleware
     *
     * @return $this
     */
    public function attach($middleware)
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
