<?php

namespace App\Controller;

use App\Model\Users;
use Phalcon\Mvc\Controller;

/**
 * User Controller.
 *
 * @package App\Controller
 */
class UserController extends Controller
{
    /**
     * Get user entity.
     *
     * @param null $id
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function getAction($id = null)
    {
        $user = Users::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);
        $result = $user ? $user->toArray() : [];
        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent($result);

        return $this->response;
    }

    /**
     * Get user list.
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function listAction()
    {
        $list = Users::find();
        $this->response
            ->setStatusCode(200, 'OK')
            ->sendHeaders()
            ->setJsonContent($list);

        return $this->response;
    }
}
