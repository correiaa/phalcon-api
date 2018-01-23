<?php

namespace App\Validation;

use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;

class UserValidation extends Validation
{
    public function addValidate()
    {
        $this->add('email', new PresenceOf(
            [
                'message' => '邮箱必须填写',
            ]
        ));
        $this->add('email', new Email(
            [
                'message' => '邮箱地址有误',
            ]
        ));
    }
}
