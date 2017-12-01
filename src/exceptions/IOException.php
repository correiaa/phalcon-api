<?php

namespace App\Exception;

/**
 * IO Exception.
 *
 * @package App\Exception
 */
class IOException extends \RuntimeException
{
    /**
     * @var string|null
     */
    private $path;

    /**
     * IOException constructor.
     *
     * @param string          $message
     * @param int             $code
     * @param \Throwable|null $previous
     * @param null            $path
     */
    public function __construct(
        $message = '',
        $code = 0,
        \Throwable $previous = null,
        $path = null
    ) {
        $this->path = $path;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }
}
