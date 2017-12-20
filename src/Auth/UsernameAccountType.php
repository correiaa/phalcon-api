<?php

namespace App\Auth;

/**
 * UsernameAccountType Class.
 *
 * @package App\Auth
 */
class UsernameAccountType implements AccountTypeInterface
{
    const NAME = 'username';

    public function login(array $data)
    {
    }

    public function authenticate($identity)
    {
    }
}
