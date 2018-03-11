<?php

namespace App\Resource;

use App\Controller\UserController;
use App\Model\User;
use Nilnice\Phalcon\Acl\Adapter\Memory;
use Nilnice\Phalcon\Endpoint;
use Nilnice\Phalcon\Resource;

class UserResource extends Resource
{
    public function initialize() : void
    {
        $this->setName('User')
            ->setDescription('这是用户接口')
            ->setItemKey('user')
            ->setCollectionKey('users')
            ->setModel(User::class)
            ->setHandler(UserController::class, true)
            ->setEndpoint(Endpoint::all()
                ->setName('all')
                ->setAllowRoles(Memory::USER)
                ->setDenyRoles(Memory::UNAUTHORIZED)
                ->setDescription('返回所有的注册用户')
            )
            ->setEndpoint(Endpoint::get('/get/{id}', 'getAction')
                ->setName('get')
                ->setAllowRoles(Memory::UNAUTHORIZED)
                ->setDenyRoles(Memory::UNAUTHORIZED)
                ->setDescription('通过用户 ID 获取用户信息')
            )
            ->setEndpoint(Endpoint::post('/register', 'registerAction')
                ->setName('register')
                ->setAllowRoles(Memory::USER)
                ->setDenyRoles(Memory::UNAUTHORIZED)
                ->setDescription('用户请求注册')
            )
            ->setEndpoint(Endpoint::post('/list', 'listAction')
                ->setName('list')
                ->setAllowRoles(Memory::UNAUTHORIZED)
                ->setDenyRoles(Memory::UNAUTHORIZED)
                ->setDescription('获取用户列表')
            )
            ->setEndpoint(Endpoint::post('/authorize', 'authorizeAction')
                ->setName('authorize')
                ->setAllowRoles(Memory::UNAUTHORIZED)
                ->setDenyRoles(Memory::UNAUTHORIZED)
                ->setDescription('为注册的用户提供授权服务')
            );
    }
}
