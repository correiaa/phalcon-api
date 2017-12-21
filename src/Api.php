<?php

namespace App;

use Phalcon\Mvc\Micro;

/**
 * Api Class.
 *
 * @package App
 */
class Api extends Micro
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
        if ( ! $this->getEventsManager()) {
            $this->setEventsManager(
                $this->getDI()->get(Service::EVENTS_MANAGER)
            );
        }

        $this->getEventsManager()->attach('micro', $middleware);

        return $this;
    }
}
