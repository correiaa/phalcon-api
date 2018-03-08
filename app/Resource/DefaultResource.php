<?php

namespace App\Resource;

use App\Controller\DefaultController;
use Nilnice\Phalcon\Constant\Role;
use Nilnice\Phalcon\Endpoint;
use Nilnice\Phalcon\Resource;

class DefaultResource extends Resource
{
    public function initialize() : void
    {
        $this->setName('All')
            ->setItemKey('all')
            ->setHandler(DefaultController::class, true)
            ->setEndpoint(Endpoint::get('/', 'indexAction')
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDescription('获取系统信息列表')
            )
            ->setEndpoint(Endpoint::get('view', 'viewAction')
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDescription('查看系统信息')
            );
    }
}
