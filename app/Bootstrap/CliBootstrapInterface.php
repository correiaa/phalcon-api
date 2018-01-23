<?php

namespace App\Bootstrap;

use App\Cli;
use Phalcon\Config\Adapter\Ini;
use Phalcon\DiInterface;

interface CliBootstrapInterface
{
    /**
     * Run some services.
     *
     * @param \App\Cli                    $cli
     * @param \Phalcon\DiInterface        $di
     * @param \Phalcon\Config\Adapter\Ini $ini
     *
     * @return mixed
     */
    public function run(Cli $cli, DiInterface $di, Ini $ini);
}
