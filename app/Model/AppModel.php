<?php

namespace App\Model;

use Phalcon\Mvc\Model;

class AppModel extends Model
{
    /**
     * @var string
     */
    public $createAt;

    /**
     * @var string
     */
    public $updateAt;

    public function beforeCreate() : void
    {
        $this->createAt = date('Y-m-d H:i:s');
        $this->updateAt = $this->createAt;
    }

    public function beforeUpdate() : void
    {
        $this->updateAt = date('Y-m-d H:i:s');
    }
}
