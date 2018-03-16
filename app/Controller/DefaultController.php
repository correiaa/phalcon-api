<?php

namespace App\Controller;

use Nilnice\Phalcon\Http\Response;
use Phalcon\Version;

class DefaultController extends AbstractController
{
    /**
     * Get default page.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function indexAction() : Response
    {
        $message = '欢迎访问 Phalcon RESTful API.';
        $result = [
            'description'   => '🔥 This is a RESTful API micro application based on Phalcon framework.',
            'documentation' => 'https://github.com/imajinyun/phalcon-api/wiki/',
        ];

        return $this->successResponse($message, $result);
    }

    /**
     * Get system information.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function infoAction() : Response
    {
        $result = [
            'phalcon'     => [
                'id'      => Version::getId(),
                'version' => Version::get(),
            ],
            'application' => [
                'clientAddress' => $this->request->getClientAddress(),
                'clientCharset' => $this->request->getClientCharsets(),
                'httpHost'      => $this->request->getHttpHost(),
                'userAgent'     => $this->request->getUserAgent(),
                'uri'           => $this->request->getURI(),
                'port'          => $this->request->getPort(),
                'scheme'        => $this->request->getScheme(),
                'method'        => $this->request->getMethod(),
                'serverName'    => $this->request->getServerName(),
                'serverAddress' => $this->request->getServerAddress(),
                'contentType'   => $this->request->getContentType(),
                'basicAuth'     => $this->request->getBasicAuth(),
                'languages'     => $this->request->getLanguages(),
            ],
        ];

        return $this->successResponse('System information.', $result);
    }
}
