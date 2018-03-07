<?php

namespace App\Resource;

use App\Controller\DefaultController;
use Nilnice\Phalcon\Constant\Role;
use Nilnice\Phalcon\Resource;
use Phalcon\Mvc\Model;

class DefaultResource extends Resource
{
    public function initialize() : void
    {
        $this->setName('All')
            ->setItemKey('all')
            ->setModel(Model::class)
            ->setHandler(DefaultController::class, true)
            ->setEndpoint(Endpoint::post('/index', 'viewAction')
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDescription('获取系统信息列表')
            );
    }
}
