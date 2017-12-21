<?php

namespace App\Middleware;

use App\Api;
use App\Service;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use Phalcon\Mvc\User\Plugin;

/**
 * Authentication Middleware.
 *
 * @property \App\Http\Request $request
 * @property \App\Auth\Manager $authManager
 *
 * @package App\Middleware
 */
class AuthenticationMiddleware extends Plugin implements MiddlewareInterface
{
    /**
     * Before anything happens.
     *
     * @param \Phalcon\Events\Event $event
     * @param \App\Api              $api
     *
     * @return string
     * @throws \Phalcon\Exception
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
