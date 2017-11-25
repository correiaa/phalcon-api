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
        exit(1);
    }
}

if (!function_exists('json')) {
    /**
     * Returns an JSON string of information about a single variable.
     *
     * @param mixed $args
     */
    function json($args)
    {
        echo (new \Phalcon\Debug\Dump())->toJson($args);
        exit(1);
    }
}
