<?php

namespace App\Auth;

use App\Model\Users;
use App\Service;
use Phalcon\Di;

class UsernameAccountType implements AccountTypeInterface
{
    public const NAME = 'username';

    /**
     * @param array $data
     *
     * @return mixed|null|string
     */
    public function login(array $data)
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Service::SECURITY);
        $username = $data[Manager::LOGIN_USERNAME];
        $password = $data[Manager::LOGIN_PASSWORD];

        $columns = (new Users())->columnMap();
        $bindParams = ['username' => $username];
        $user = Users::query()
                     ->columns($columns)
                     ->where('username=:username:')
                     ->bind($bindParams)
                     ->limit(1)
                     ->execute();

        if (! $user) {
            return null;
        }

        if (! $security->checkHash($password, $user->password)) {
            return null;
        }

        return (string)$user->id;
    }

    /**
     * User authenticate.
     *
     * @param string $identity
     *
     * @return bool|mixed
     */
    public function authenticate($identity)
    {
        $count = Users::count([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $identity],
        ]);

        return $count > 0;
    }
}
