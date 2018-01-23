<?php

namespace App\Auth;

use App\Auth\Provider\JWTProvider;
use Firebase\JWT\JWT;
use Phalcon\Exception;

class JWTToken implements JWTTokenInterface
{
    const ALGORITHM_HS256 = 'HS256';
    const ALGORITHM_HS512 = 'HS512';
    const ALGORITHM_HS384 = 'HS384';
    const ALGORITHM_RS256 = 'RS256';

    /** @var string Secret. */
    private $secret;

    /** @var string Algorithm. */
    private $algorithm;

    /**
     * JWTToken constructor.
     *
     * @param string $secret
     * @param string $algorithm
     *
     * @throws \Phalcon\Exception
     */
    public function __construct($secret, $algorithm = self::ALGORITHM_HS256)
    {
        if (! class_exists(JWT::class)) {
            throw new Exception('You need to load the JWT class.');
        }
        $this->secret = $secret;
        $this->algorithm = $algorithm;
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        $this->secret = $secret;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @param string $algorithm
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
    }

    /**
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * @param \App\Auth\Provider\JWTProvider $JWTProvider
     *
     * @return mixed|string
     */
    public function getToken(JWTProvider $JWTProvider)
    {
        $data = $this->payload(
            $JWTProvider->getAccountTypeName(),
            $JWTProvider->getIdentity(),
            $JWTProvider->getStartTime(),
            $JWTProvider->getExpirationTime()
        );

        return $this->encode($data);
    }

    /**
     * @param string $token
     *
     * @return string
     */
    public function encode($token)
    {
        return JWT::encode($token, $this->secret, $this->algorithm);
    }

    /**
     * @param string $token
     *
     * @return object
     */
    public function decode($token)
    {
        return JWT::decode($token, $this->secret, [$this->algorithm]);
    }

    /**
     * @param string $token
     *
     * @return \App\Auth\Provider\JWTProvider
     */
    public function getProvider($token)
    {
        $token = $this->decode($token);

        return new JWTProvider(
            $token->iss,
            $token->sub,
            $token->iat,
            $token->exp
        );
    }

    /**
     * @param string $iss
     * @param mixed  $user
     * @param int    $iat
     * @param int    $exp
     *
     * @return array
     */
    private function payload($iss, $user, $iat, $exp)
    {
        return [
            'iss' => $iss,
            'sub' => $user,
            'iat' => $iat,
            'exp' => $exp,
        ];
    }
}
