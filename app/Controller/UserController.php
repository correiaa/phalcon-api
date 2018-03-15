<?php

namespace App\Controller;

use App\Auth\UsernameAccountType;
use App\Model\User;
use App\Validation\UserValidation;
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
            return $this->warningResponse([], 'Invalid parameter');
        }

        $entity = User::findFirst([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $id],
        ]);
        $data = $entity ? $entity->toArray() : [];

        return $this->successResponse($data);
    }

    /**
     * Create or register user.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function createAction() : Response
    {
        $array = $this->request->getPost();

        $validation = new UserValidation();
        $validation->createValidate($array);
        $validator = $this->validator($validation, $array);

        if ($validator['message']) {
            return $this->warningResponse($validator, $validator['message']);
        }

        $email = Arr::get($array, 'email', '');
        $username = Arr::get($array, 'username', '');
        $nickname = Arr::get($array, 'nickname', '');
        $password = Arr::get($array, 'password', '');
        $createIp = $this->request->getClientAddress();

        // Filter post data.
        $filter = new Filter();
        $email = $filter->sanitize($email, ['trim', 'email']);
        $username = $filter->sanitize($username, ['trim']);
        $nickname = $filter->sanitize($nickname, ['trim']);
        $password = $filter->sanitize($password, ['trim']);

        $user = new User();
        $user->setEmail($email);
        $user->setUsername($username);
        $user->setNickname(ucfirst($nickname));
        $user->setPassword($this->security->hash($password));
        $user->setRole('User');
        $user->setCreatedIp($createIp);

        if ($user->save()) {
            return $this->successResponse([], '注册成功');
        }

        return $this->warningResponse([], '注册失败');
    }

    /**
     * Update user information.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function updateAction() : Response
    {
        $array = $this->request->getPost();
        $id = Arr::get($array, 'id');

        if (! $id) {
            return $this->warningResponse([], 'Invalid parameter');
        }
        $data = $array;

        $object = User::findFirst([
            'conditions' => 'id = :id:',
            'bind'       => ['id' => $id],
        ]);

        if (! $object) {
            return $this->warningResponse($data, 'User not found');
        }

        return $this->successResponse($data);
    }

    /**
     * Get some users list.
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
     * Get token information.
     *
     * @return \Nilnice\Phalcon\Http\Response
     */
    public function infoAction() : Response
    {
        /** @var \Nilnice\Phalcon\Auth\Manager $manager */
        $manager = $this->di->get('authManager');
        $provider = $manager->getJWTProvider();
        $data = [
            'token'   => $provider->getToken(),
            'user_id' => $provider->getIdentity(),
        ];

        return $this->successResponse($data);
    }
}
