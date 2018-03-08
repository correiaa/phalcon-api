<?php

namespace App\Auth;

use App\Model\User;
use App\Service;
use Nilnice\Phalcon\Auth\AccountTypeInterface;
use Nilnice\Phalcon\Auth\Manager;
use Phalcon\Di;

class UsernameAccountType implements AccountTypeInterface
{
    public const NAME = 'username';

    /**
     * Use username login.
     *
     * @param array $data
     *
     * @return string
     */
    public function login(array $data) : string
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
     * @return bool
     */
    public function authenticate(string $identity) : bool
    {
        $count = User::count([
            'conditions' => 'id=:id:',
            'bind'       => ['id' => $identity],
        ]);

        return $count > 0;
    }
}
