<?php

namespace App\Resource;

use App\Controller\DefaultController;
use Nilnice\Phalcon\Acl\Adapter\Memory;
use Nilnice\Phalcon\Endpoint;
use Nilnice\Phalcon\Resource;

class DefaultResource extends Resource
{
    public function initialize() : void
    {
        $this->setName('Default')
            ->setDescription('这是默认接口')
            ->setItemKey('default')
            ->setCollectionKey('defaults')
            ->setHandler(DefaultController::class, true)
            ->setEndpoint(Endpoint::get('/', 'indexAction')
                ->setName('index')
                ->setAllowRoles(Memory::UNAUTHORIZED)
                ->setDescription('获取系统信息列表')
            )
            ->setEndpoint(Endpoint::get('view', 'viewAction')
                ->setName('view')
                ->setAllowRoles(Memory::UNAUTHORIZED)
                ->setDescription('查看系统信息')
            );
    }
}
