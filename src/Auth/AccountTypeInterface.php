<?php

namespace App\Auth;

/**
 * AccountType Interface.
 *
 * @package App\Auth
 */
interface AccountTypeInterface
{
    /**
     * User login.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function login(array $data);

    /**
     * User authentication.
     *
     * @param string $identity
     *
     * @return mixed
     */
    public function authenticate($identity);
}
