<?php

namespace App\Resource;

use App\Controller\UserController;
use App\Model\User;
use Nilnice\Phalcon\Constant\Role;
use Nilnice\Phalcon\Endpoint;
use Nilnice\Phalcon\Resource;

class UserResource extends Resource
{
    public function initialize() : void
    {
        $this->setName('User')
            ->setItemKey('user')
            ->setModel(User::class)
            ->setHandler(UserController::class, true)
            ->setEndpoint(Endpoint::all()
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDescription('返回所有的注册用户')
            )
            ->setEndpoint(Endpoint::get('/get/{id}', 'getAction')
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDescription('通过用户 ID 获取用户信息')
            )
            ->setEndpoint(Endpoint::post('/list', 'listAction')
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDescription('获取用户列表')
            )
            ->setEndpoint(Endpoint::post('/authorize', 'authorizeAction')
                ->setAllowRoles(Role::UNAUTHORIZED)
                ->setDenyRoles(Role::AUTHORIZED)
                ->setDescription('为注册的用户提供授权服务')
            );
    }
}
