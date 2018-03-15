<?php

namespace App\Validation;

use App\Validation\Validator\UserEmailValidator;
use Illuminate\Support\Arr;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class UserValidation extends Validation
{
    public function initialize()
    {
        $this->add('email', new PresenceOf([
            'message' => '邮箱必须填写',
        ]));

        $this->add('username', new PresenceOf([
            'message' => '用户名称必须填写',
        ]));

        $this->add('password', new PresenceOf([
            'message' => '用户密码必须填写',
        ]));

        $this->add('nickname', new PresenceOf([
            'message' => '用户昵称必须填写',
        ]));
    }

    /**
     * @param array|null $array
     */
    public function createValidate(array $array = null) : void
    {
        $email = Arr::get($array, 'email');

        $this->add('email', new Email([
            'message' => '邮箱地址有误',
        ]));

        $this->add('email', new UserEmailValidator([
            'email'   => $email,
            'message' => '邮箱已经存在',
        ]));
    }

    /**
     * @param array|null $array
     */
    public function updateValidate(array $array = null) : void
    {
        $email = Arr::get($array, 'email');

        $this->add('email', new UserEmailValidator([
            'email'   => $email,
            'message' => '邮箱已经存在',
        ]));
    }
}
