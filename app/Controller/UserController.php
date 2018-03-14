<?php

namespace App\Controller;

use App\Auth\UsernameAccountType;
use App\Model\User;
use Illuminate\Support\Arr;
use Nilnice\Phalcon\Http\Response;
use Phalcon\Filter;
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
        $array = $this->request->getPost();
        $email = Arr::get($array, 'email', '');
        $username = Arr::get($array, 'username', '');
        $nickname = Arr::get($array, 'nickname', '');
        $password = Arr::get($array, 'password', '');
        $ip = Arr::get($array, 'ip', '');

        // Filter post data.
        $filter = new Filter();
        $email = $filter->sanitize($email, ['trim', 'email']);
        $username = $filter->sanitize($username, ['trim']);
        $nickname = $filter->sanitize($nickname, ['trim']);
        $password = $filter->sanitize($password, ['trim']);
        $ip = $filter->sanitize($ip, ['trim']);

        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setNickname(ucfirst($nickname));
        $user->setPassword($this->security->hash($password));
        $user->setRole('User');
        $user->setCreatedIp($ip);

        if ($user->save()) {
            return $this->successResponse([], '注册成功');
        }

        return $this->warningResponse([], '注册失败');
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
