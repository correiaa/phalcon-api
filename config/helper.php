<?php

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param array ...$args
     *
     * @return null
     */
    function dd(...$args)
    {
        echo (new \Phalcon\Debug\Dump())->variables($args);
        die(1);
    }
}
