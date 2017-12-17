<?php

namespace App\Http;

/**
 * Class Request.
 *
 * @package App\Network
 */
class Request extends \Phalcon\Http\Request
{
    /**
     * Get auth username.
     *
     * @return null|string
     */
    public function getUsername()
    {
        return $this->getServer('PHP_AUTH_USER');
    }

    /**
     * Get auth password.
     *
     * @return null|string
     */
    public function getPassword()
    {
        return $this->getServer('PHP_AUTH_PW');
    }

    /**
     * Get authentication token.
     *
     * @return null|string
     */
    public function getToken()
    {
        $headerToken = $this->getHeader('AUTHORIZATION');
        $queryToken = $this->getQuery('token');

        return $headerToken ?: $this->parseBearerValue($queryToken);
    }

    /**
     * Parse `Bearer` value.
     *
     * @param string $string
     *
     * @return null|string|string[]
     */
    protected function parseBearerValue($string)
    {
        if (false !== strpos(trim($string), 'Bearer')) {
            return null;
        }

        return preg_replace('/.*\s/', '', $string);
    }
}
