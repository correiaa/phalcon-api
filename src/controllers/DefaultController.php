<?php

namespace App\Controller;

use Phalcon\Mvc\Controller;

/**
 * Default Controller.
 *
 * @inheritdoc
 * @package App\Controller
 */
class DefaultController extends Controller
{
    /**
     * @return string
     */
    public function indexAction()
    {
        $this->response->setStatusCode(200, 'OK')->sendHeaders();
        $this->response->setJsonContent(['method' => __METHOD__]);

        return $this->response;
    }
}
