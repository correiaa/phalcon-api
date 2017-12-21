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
     * @param array $data
     *
     * @return mixed
     */
    public function login(array $data);

    /**
     * @param string $identity
     *
     * @return mixed
     */
    public function authenticate($identity);
}
