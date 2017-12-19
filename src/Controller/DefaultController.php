<?php

namespace App\Controller;

use Phalcon\Version;

/**
 * Default Controller.
 *
 * @package App\Controller
 */
class DefaultController extends AbstractController
{
    /**
     * Default access entry.
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function indexAction()
    {
        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent(
                [
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
                ]
            );

        return $this->response;
    }

    /**
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function utilAction()
    {
        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent(
                [
                    'getClientAddress'               => $this->request->getClientAddress(),
                    'getClientCharsets'              => $this->request->getClientCharsets(),
                    'getUserAgent'                   => $this->request->getUserAgent(),
                    'getHttpHost'                    => $this->request->getHttpHost(),
                    'getMethods'                     => $this->request->getMethod(),
                    'getHttpMethodParameterOverride' => $this->request->getHttpMethodParameterOverride(),
                    'getURI'                         => $this->request->getURI(),
                    'getPort'                        => $this->request->getPort(),
                    'getServerName'                  => $this->request->getServerName(),
                    'getServerAddress'               => $this->request->getServerAddress(),
                    'getContentType'                 => $this->request->getContentType(),
                    'getScheme'                      => $this->request->getScheme(),
                    'getBasicAuth'                   => $this->request->getBasicAuth(),
                    'getLanguages'                   => $this->request->getLanguages(),
                ]
            );

        return $this->response;
    }
}
