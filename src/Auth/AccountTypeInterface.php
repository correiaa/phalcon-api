<?php

namespace App\Auth;

/**
 * AccountType Interface.
 *
 * @copyright Copyright (c) Xiaohe Software Foundation, Inc.
 * @link      https://www.xiaohe.com/ Xiaohe(tm) Project
 * @package   App\Auth
 * @date      2017-12-20 21:21
 * @author    majinyun <majinyun@xiaohe.com>
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
