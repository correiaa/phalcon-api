<?php

namespace App\Controller;

use Firebase\JWT\JWT;

/**
 * Token Controller.
 *
 * @package App\Controller
 */
class TokenController extends AbstractController
{
    const TOKEN_TTL = 86400;

    public function getAction()
    {
        $payload = [
            'iss' => 'http://local.phalcon-api.com',
            'aud' => 'http://local.phalcon-api.com',
            'iat' => $_SERVER['REQUEST_TIME'],
            // 'nbf' => 3600,
            // 'exp' => self::TOKEN_TTL,
        ];
        $token = JWT::encode($payload, $this->getSecretKey());
        $this->response->getHeaders()->set('Authorization', $token);

        return $this->response;
    }

    public function verifyAction()
    {
        $content = [
            'status' => false,
            'msg'    => '未授权',
            'data'   => [],
        ];
        $token = $this->request->getHeader('Authorization');

        try {
            $token = JWT::decode($token, $this->getSecretKey(), ['HS256']);

            if ( ! $token) {
                $this->response->setStatusCode(401, 'Unauthorized');
            } else {
                $content['status'] = true;
                $content['msg'] = '认证成功';
                $this->response->setStatusCode(200, 'OK');
            }
            $this->response->setJsonContent($content);
        } catch (\Exception $e) {
            $this->response->setStatusCode(401, 'NO');
            $this->response->setJsonContent($e->getMessage());
        }

        return $this->response;
    }

    private function getSecretKey()
    {
        $key = $this->getDI()->get('config')->security->appsecret;

        return $key;
    }
}
