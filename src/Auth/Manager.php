<?php

namespace App\Auth;

use Phalcon\Mvc\User\Plugin;

/**
 * Manager Class.
 *
 * @package App\Auth
 */
class Manager extends Plugin
{
    const LOGIN_PHONE = 'phone';
    const LOGIN_EMAIL = 'email';
    const LOGIN_USERNAME = 'username';
    const LOGIN_PASSWORD = 'password';

    /** @var int Expiration time. */
    private $duration;

    /** @var array Account types. */
    private $accountType;

    /**
     * Manager constructor.
     *
     * @param int $duration
     */
    public function __construct($duration = 86400)
    {
        $this->duration = $duration;
        $this->accountType = [];
    }

    public function registerAccountType(
        $name,
        AccountTypeInterface $accountType
    ) {
        $this->accountType[$name] = $accountType;

        return $this;
    }

    public function loginWithUsernamePassword($type, $username, $password)
    {
        $array = [
            self::LOGIN_USERNAME => $username,
            self::LOGIN_PASSWORD => $password,
        ];

        return $this->login($type, $array);
    }

    public function login($type, array $array)
    {

    }

    public function authenticateToken($token)
    {

    }
}
