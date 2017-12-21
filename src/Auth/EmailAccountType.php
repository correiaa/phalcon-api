<?php

namespace App\Auth;

use App\Model\Users;
use App\Service;
use Phalcon\Di;

/**
 * EmailAccountType Class.
 *
 * @package App\Auth
 */
class EmailAccountType implements AccountTypeInterface
{
    const NAME = 'email';

    /**
     * @param array $data
     *
     * @return mixed|null|string
     */
    public function login(array $data)
    {
        /** @var \Phalcon\Security $security */
        $security = Di::getDefault()->get(Service::SECURITY);
        $email = $data[Manager::LOGIN_EMAIL];
        $password = $data[Manager::LOGIN_PASSWORD];

        $bindParams = ['email' => $email];
        $user = Users::findFirst([
            'columns'    => (new Users())->columnMap(),
            'conditions' => 'email=:email:',
            'limit'      => 1,
            'bind'       => $bindParams,
        ]);

        if ( ! $user) {
            return null;
        }

        if ( ! $security->checkHash($password, $user->password)) {
            return null;
        }

        return (string)$user->id;
    }

    public function authenticate($identity)
    {
    }
}
