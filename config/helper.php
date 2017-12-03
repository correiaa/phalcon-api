<?php

if ( ! function_exists('dd')) {
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

if ( ! function_exists('json')) {
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

if ( ! function_exists('logger')) {
    /**
     * Record application running log.
     *
     * @param string $msg
     * @param int    $type
     * @param string $name
     * @param array  $context
     *
     * @return null
     */
    function logger(
        $msg,
        $type = \Phalcon\Logger::INFO,
        $name = '',
        array $context = null
    ) {
        $logger = function ($func = 'info', $name = '') use ($msg, $context) {
            $y = date('Y');
            $m = date('m');
            $d = date('d');
            $formatter = LOGS . '%s/%s/%s/%s.log';
            $path = sprintf($formatter, $y, $m, $d, $name ?: $func);

            if ( ! file_exists($path)) {
                if (class_exists($class = \App\Component\Filesystem::class)) {
                    $Filesystem = new \App\Component\Filesystem();
                    $Filesystem->mkdir(dirname($path));
                } else {
                    throw new \RuntimeException("$class cannot be loaded.");
                }
            }
            $Logger = new \Phalcon\Logger\Adapter\File($path);
            $Logger->{$func}($msg, $context);
        };

        switch ($type) {
            case 0:
                $logger('emergence', $name);
                break;
            case 1:
                $logger('critical', $name);
                break;
            case 2:
                $logger('alert', $name);
                break;
            case 3:
                $logger('error', $name);
                break;
            case 4:
                $logger('warning', $name);
                break;
            case 5:
                $logger('notice', $name);
                break;
            case 7:
                $logger('debug', $name);
                break;
            default:
                $logger('info', $name);
                break;
        }
    }
}
