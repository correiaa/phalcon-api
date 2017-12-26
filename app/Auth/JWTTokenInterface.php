<?php

namespace App\Auth;

use App\Auth\Provider\JWTProvider;

/**
 * JWTToken Interface.
 *
 * @package App\Auth
 */
interface JWTTokenInterface
{
    /**
     * @param \App\Auth\Provider\JWTProvider $JWTProvider
     *
     * @return mixed
     */
    public function getToken(JWTProvider $JWTProvider);
}
