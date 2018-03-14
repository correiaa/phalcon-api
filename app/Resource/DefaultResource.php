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
                ->setAllowRoles(Memory::All_ROLES)
                ->setDescription('默认欢迎页面')
            )
            ->setEndpoint(Endpoint::get('info', 'infoAction')
                ->setName('info')
                ->setAllowRoles(Memory::All_ROLES)
                ->setDescription('查看系统信息页面')
            );
    }
}
