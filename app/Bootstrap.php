<?php

namespace App;

/**
 * Bootstrap Class.
 *
 * @package App
 */
class Bootstrap
{
    /** @var \App\Bootstrap[] $bootstraps */
    private $bootstraps;

    /**
     * App constructor.
     *
     * @param array ...$bootstraps
     */
    public function __construct(...$bootstraps)
    {
        $this->bootstraps = $bootstraps;
    }

    /**
     * @param array ...$args
     */
    public function run(...$args)
    {
        foreach ($this->bootstraps as $bootstrap) {
            call_user_func_array([$bootstrap, 'run'], $args);
        }
    }
}
