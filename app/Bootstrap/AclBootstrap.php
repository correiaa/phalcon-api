<?php

namespace App\Bootstrap;

use Nilnice\Phalcon\Acl\Adapter\Memory;
use Nilnice\Phalcon\App;
use Nilnice\Phalcon\AppBootstrapInterface;
use Nilnice\Phalcon\Constant\Service;
use Phalcon\Acl\Role;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

class AclBootstrap implements AppBootstrapInterface
{
    public function run(App $app, DiInterface $di, Ini $ini)
    {
        /** @var \Nilnice\Phalcon\Acl\Adapter\Memory $acl */
        $acl = $app->getDI()->get(Service::ACL);

        $unauthorizedRole = new Role(Memory::UNAUTHORIZED);
        $authorizedRole = new Role(Memory::AUTHORIZED);

        $acl->addRole($unauthorizedRole);
        $acl->addRole($authorizedRole);
        $acl->addRole(Memory::USER, $authorizedRole);
        $acl->addRole(Memory::MANAGER, $authorizedRole);
        $acl->addRole(Memory::ADMINISTRATOR, $authorizedRole);

        $mounts = $app->getCollections();
        $acl->setMounts($mounts);
    }
}
