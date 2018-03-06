<?php

namespace App\Auth;

use App\Model\User;
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

        $user = User::findFirst([
            'conditions' => 'username = :username:',
            'bind'       => ['username' => $username],
        ]);

        if (! $user) {
            return null;
        }

        if (! $security->checkHash($password, $user->getPassword())) {
            return null;
        }

        return (string)$user->getId();
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
        $count = User::count([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $identity],
        ]);

        return $count > 0;
    }
}
