<?php

namespace App\Controller;

use Firebase\JWT\JWT;
use Phalcon\Mvc\Controller;

/**
 * Token Controller.
 *
 * @package App\Controller
 */
class TokenController extends Controller
{
    public function getAction()
    {
        $key = random_bytes(20);
        $payload = [
            'iss' => 'http://local.phalcon-api.com',
            'aud' => 'http://local.phalcon-api.com',
            'iat' => time(),
            'nbf' => time(),
        ];

        $jwt = JWT::encode($payload, $key);
        $decoded = JWT::decode($jwt, $key, ['HS256']);

        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent($decoded);

        return $this->response;
    }
}

