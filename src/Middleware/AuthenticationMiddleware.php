<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * AuthenticationMiddleware Class.
 *
 * @package App\Middleware
 */
class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens.
     *
     * @param \Phalcon\Events\Event $event
     * @param \Phalcon\Mvc\Micro    $micro
     */
    public function beforeExecuteRoute(Event $event, Micro $micro)
    {
        $token = $micro->request->getToken();
    }

    /**
     * Calls the middleware.
     *
     * @param \Phalcon\Mvc\Micro $micro
     *
     * @return bool
     */
    public function call(Micro $micro)
    {
        return true;
    }
}
