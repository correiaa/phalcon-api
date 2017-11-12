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
        return __METHOD__;
    }
}
