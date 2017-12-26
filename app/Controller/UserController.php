<?php

namespace App\Controller;

use App\Auth\EmailAccountType;
use App\Auth\UsernameAccountType;
use App\Model\Users;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * User Controller.
 *
 * @property \App\Auth\Manager $authManager
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

        return $this->successResponse($array);
    }

    /**
     * User authenticate.
     *
     * @return null|\Phalcon\Http\Response|\Phalcon\Http\ResponseInterface
     * @throws \Phalcon\Exception
     */
    public function authenticateAction()
    {
        $username = $this->request->getUsername();
        $password = $this->request->getPassword();
        $JWTProvider = $this->authManager->loginWithUsernamePassword(
            EmailAccountType::NAME,
            $username,
            $password
        );
        $user = Users::findFirst(
            [
                'conditions' => 'id=:id:',
                'bind'       => ['id' => $JWTProvider->getIdentity()],
            ]
        );

        if ( ! $user) {
            return null;
        }
        $result = [
            'token'  => $JWTProvider->getToken(),
            'expire' => $JWTProvider->getExpirationTime(),
            'user'   => $user->toArray(),
        ];

        return $this->successResponse($result);
    }
}
