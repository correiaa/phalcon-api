<?php

namespace App;

use Phalcon\Mvc\Micro;

/**
 * Api Class.
 *
 * @copyright Copyright (c) Xiaohe Software Foundation, Inc.
 * @link      https://www.xiaohe.com/ Xiaohe(tm) Project
 * @package   App
 * @date      2017-12-19 21:44
 * @author    majinyun <majinyun@xiaohe.com>
 */
class Api extends Micro
{
    /**
     * Attach middleware.
     *
     * @param object $middleware
     *
     * @return $this
     */
    public function attach($middleware)
    {
        if ( ! $this->getEventsManager()) {
            $this->setEventsManager(
                $this->getDI()->get(Service::EVENT_MANAGER)
            );
        }

        $this->getEventsManager()->attach('micro', $middleware);

        return $this;
    }
}
