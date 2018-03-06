<?php

namespace App\Controller;

use App\Auth\UsernameAccountType;
use App\Model\User;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * @property \App\Auth\Manager $authManager
 */
class UserController extends AbstractController
{
    /**
     * Get user entity.
     *
     * @param string|null $id
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     */
    public function getAction($id = null)
    {
        if (! $id) {
            return $this->warning([], 'Invalid parameter.');
        }

        $entity = User::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);
        $data = $entity ? $entity->toArray() : [];

        return $this->success($data);
    }

    /**
     * User authorize.
     *
     * @return \Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @throws \Phalcon\Exception
     */
    public function authorizeAction()
    {
        $request = $this->request;
        $username = $request->getUsername();
        $password = $request->getPassword();

        $auth = $this->authManager->loginWithUsernamePassword(
            UsernameAccountType::NAME,
            $username,
            $password
        );

        $user = User::findFirst($auth->getIdentity());
        $data = [
            'token'  => $auth->getToken(),
            'expire' => $auth->getExpirationTime(),
            'user'   => $user->toArray(),
        ];

        return $this->successResponse($data);
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
            ->from(User::class)
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

        return $this->successResponse($array);
    }
}
