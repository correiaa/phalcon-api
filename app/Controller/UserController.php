<?php

namespace App\Controller;

use App\Auth\UsernameAccountType;
use App\Model\User;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * @property \Nilnice\Phalcon\Auth\Manager $authManager
 */
class UserController extends AbstractController
{
    /**
     * Get user entity.
     *
     * @param mixed|null $id
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function getAction($id = null) : Response
    {
        if (! $id) {
            return $this->warningResponse([], 'Invalid parameter.');
        }

        $entity = User::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);
        $data = $entity ? $entity->toArray() : [];

        return $this->successResponse($data);
    }

    public function registerAction()
    {
        dd($this->request->getPost());
    }

    /**
     * User authorize.
     *
     * @return \Nilnice\Phalcon\Http\Response
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function authorizeAction() : Response
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
            'user'   => $user ? $user->toArray() : [],
        ];

        return $this->successResponse($data);
    }

    /**
     * Get user list.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function listAction() : Response
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
