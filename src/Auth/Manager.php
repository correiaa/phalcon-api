<?php

namespace App\Auth;

use App\Auth\Provider\JWTProvider;
use App\Message;
use Phalcon\Exception;
use Phalcon\Mvc\User\Plugin;

/**
 * Manager Class.
 *
 * @property \App\Auth\JWTToken $jwtToken
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

    /** @var \App\Auth\Provider\JWTProvider */
    private $jwtProvider;

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

    /**
     * Register account type.
     *
     * @param string                         $name
     * @param \App\Auth\AccountTypeInterface $accountType
     *
     * @return $this
     */
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
            self::LOGIN_EMAIL    => $username,
            self::LOGIN_PASSWORD => $password,
        ];

        return $this->login($type, $array);
    }

    public function login($type, array $array)
    {
        if ( ! $account = $this->getAccountType($type)) {
            throw new Exception(Message::AUTH_ACCOUNT_TYPE_INVALID);
        }

        if ( ! $identity = $account->login($array)) {
            throw new Exception(Message::AUTH_LOGIN_FAILED);
        }

        $startTime = time();
        $expirationTime = $this->duration + $startTime;
        $JWTProvider = new JWTProvider(
            $type,
            $identity,
            $startTime,
            $expirationTime
        );
        $token = $this->jwtToken->getToken($JWTProvider);
        $JWTProvider->setToken($token);
        $this->jwtProvider = $JWTProvider;

        return $this->jwtProvider;
    }

    public function authenticateToken($token)
    {
        try {
            $token = $this->jwtToken->getProvider($token);
            dd($token);
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    /**
     * Get account type.
     *
     * @param $type
     *
     * @return mixed|null
     */
    public function getAccountType($type)
    {
        if (array_key_exists($type, $this->accountType)) {
            return $this->accountType[$type];
        }

        return null;
    }
}
