<?php

namespace App\Model;

trait ModelTrait
{
    public function beforeCreate()
    {
        $this->createAt = date('Y-m-d H:i:s');
        $this->updateAt = $this->createAt;
    }

    public function beforeUpdate()
    {
        $this->updateAt = date('Y-m-d H:i:s');
    }
}
