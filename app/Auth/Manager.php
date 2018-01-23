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
    public const LOGIN_PHONE = 'phone';
    public const LOGIN_EMAIL = 'email';
    public const LOGIN_USERNAME = 'username';
    public const LOGIN_PASSWORD = 'password';

    /**
     * @var int Expiration time.
     */
    private $duration;

    /**
     * @var \App\Auth\Provider\JWTProvider
     */
    private $jwtProvider;

    /**
     * @var array Account types.
     */
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

    /**
     * Login with user username and password.
     *
     * @param string $type
     * @param string $username
     * @param string $password
     *
     * @return \App\Auth\Provider\JWTProvider
     * @throws \Phalcon\Exception
     */
    public function loginWithUsernamePassword($type, $username, $password)
    {
        $array = [
            self::LOGIN_EMAIL    => $username,
            self::LOGIN_PASSWORD => $password,
        ];

        return $this->login($type, $array);
    }

    /**
     * User login.
     *
     * @param string $type
     * @param array  $array
     *
     * @return \App\Auth\Provider\JWTProvider
     * @throws \Phalcon\Exception
     */
    public function login($type, array $array)
    {
        if (! $account = $this->getAccountType($type)) {
            throw new Exception(Message::AUTH_ACCOUNT_TYPE_INVALID);
        }

        if (! $identity = $account->login($array)) {
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

    /**
     * Authentication token.
     *
     * @param string $token
     *
     * @return bool
     * @throws \Phalcon\Exception
     */
    public function authenticateToken($token)
    {
        try {
            $JWTToken = $this->jwtToken->getProvider($token);
        } catch (Exception $e) {
            throw new Exception(Message::AUTH_TOKEN_INVALID);
        }

        if (! $JWTToken) {
            return false;
        }

        if ($JWTToken->getExpirationTime() < time()) {
            throw new Exception(Message::AUTH_TOKEN_EXPIRED);
        }
        $JWTToken->setToken($token);

        /** @var \App\Auth\AccountTypeInterface $account */
        $account = $this->getAccountType($JWTToken->getAccountTypeName());
        if (! $account) {
            throw new Exception(Message::AUTH_TOKEN_FAILED);
        }

        if (! $account->authenticate($JWTToken->getIdentity())) {
            throw new Exception(Message::AUTH_TOKEN_INVALID);
        }
        $this->jwtProvider = $JWTToken;

        return true;
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
