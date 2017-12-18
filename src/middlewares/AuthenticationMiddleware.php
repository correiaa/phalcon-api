<?php

namespace App\Middleware;

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
     * @param \Phalcon\Mvc\Micro $application
     *
     * @return bool
     */
    public function call(Micro $application)
    {
        return true;
    }
}
