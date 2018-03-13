<?php

namespace App\User;

use App\Model\User as UserModel;
use Nilnice\Phalcon\Acl\Adapter\Memory;
use Phalcon\Mvc\Model;

class User extends \Nilnice\Phalcon\Mvc\User\User
{
    /**
     * @var array
     */
    private $user = [];

    /**
     * Get user role.
     *
     * @return string
     *
     * @throws \Nilnice\Phalcon\Exception\Exception
     */
    public function getRole() : string
    {
        $role = Memory::UNAUTHORIZED;
        $user = empty($this->getUser()) ? null : $this->getUser();

        if ($user && \in_array($user['role'], Memory::All_ROLES, true)) {
            $role = $user['role'];
        }

        return $role;
    }

    /**
     * @param string $identity
     *
     * @return \App\Model\User
     */
    public function getUserByIdentity(string $identity) : Model
    {
        if (array_key_exists($identity, $this->user)) {
            return $this->user[$identity];
        }

        $user = UserModel::findFirst($identity);
        $this->user[$identity] = $user;

        return $user;
    }
}
