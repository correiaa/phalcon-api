<?php

namespace App\Controller;

use App\Traits\ResultsetTrait;
use App\Model\Users;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * User Controller.
 *
 * @package App\Controller
 */
class UserController extends AbstractController
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
        if ( ! $id) {
            return $this->warning([], 'Invalid parameter.');
        }

        $entity = Users::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);
        $data = $entity ? $entity->toArray() : [];

        return $this->success($data);
    }

    /**
     * Get user list.
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function listAction()
    {
        $limit = 10;
        $builder = $this->modelsManager
            ->createBuilder()
            ->columns('*')
            ->from(Users::class)
            ->where(true)
            ->orderBy('createdAt DESC');

        $paginator = new QueryBuilder(
            [
                'builder' => $builder,
                'limit'   => $limit,
                'page'    => 1,
            ]
        );
        $array = [
            'total' => $paginator->getPaginate()->total_items,
            'pages' => $paginator->getPaginate()->total_pages,
            'page'  => $paginator->getCurrentPage(),
            'limit' => $paginator->getLimit(),
            'list'  => $paginator->getPaginate()->items,
        ];

        return $this->success($array);
    }

    public function authenticateAction()
    {
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();

        // TODO: find user information by username and password.
        $user = [
            'id'       => 1001,
            'username' => $username,
            'password' => $password,
        ];

        return $this->success($user);
    }
}
