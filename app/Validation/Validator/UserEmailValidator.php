<?php

namespace App\Validation\Validator;

use App\Model\User;
use Phalcon\Validation;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class UserEmailValidator extends Validator
{
    /**
     * User email validate.
     *
     * @param \Phalcon\Validation $validation
     * @param string              $attribute
     *
     * @return bool
     */
    public function validate(Validation $validation, $attribute) : bool
    {
        $value = $validation->getValue($attribute);
        $data = [
            'id'    => $this->getOption('id'),
            'email' => $value,
        ];

        if (self::isUserEmailExist($data)) {
            $message = $this->getOption('message');

            if (! $message) {
                $message = '邮箱已经存在';
            }
            $validation->appendMessage(
                new Message($message, $attribute, 'email')
            );

            return false;
        }

        return true;
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public static function isUserEmailExist(array $data) : bool
    {
        $conditions = ' 1 ';
        $bind = [];
        ['id' => $id, 'email' => $email] = $data;

        if ($id) {
            $conditions .= 'AND id <> :id:';
            $bind['id'] = $id;
        }

        if ($email) {
            $conditions .= 'AND email = :email:';
            $bind['email'] = $email;
        }
        $count = User::count(['conditions' => $conditions, 'bind' => $bind]);

        return $count > 0;
    }
}
