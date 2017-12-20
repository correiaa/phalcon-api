<?php

namespace App\Middleware;

use App\Api;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * Authentication Middleware.
 *
 * @package App\Middleware
 */
class AuthenticationMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens.
     *
     * @param \Phalcon\Events\Event $event
     * @param \App\Api              $api
     *
     * @return string
     */
    public function beforeExecuteRoute(Event $event, Api $api)
    {
        $token = $api->request->getToken();

        if ($token) {
            $this->authManager->authenticateToken($token);
        }
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
