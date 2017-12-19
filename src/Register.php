<?php

namespace App;

use Phalcon\DiInterface;
use Phalcon\Loader;

/**
 * Register Class.
 *
 * @package App
 */
class Register
{
    /** @var \Phalcon\DiInterface $di */
    private $di;

    /** @var \Phalcon\Loader $loader */
    private $loader;

    /**
     * Register constructor.
     *
     * @param \Phalcon\DiInterface $di
     * @param \Phalcon\Loader      $loader
     */
    public function __construct(DiInterface $di, Loader $loader)
    {
        $this->di = $di;
        $this->loader = $loader;
    }

    /**
     * Main bootstrap entry.
     */
    public function main()
    {
        $this->registerFiles();
        $this->registerNamespaces();
        $this->registerDirs();
    }

    /**
     * Register directories.
     */
    protected function registerDirs()
    {
        $directories = [APP_DIR];
        $this->loader->registerDirs($directories);
        $this->loader->register();
    }

    /**
     * Register namespaces.
     */
    protected function registerNamespaces()
    {
        $namespaces = ['App' => APP_DIR];
        $this->loader->registerNamespaces($namespaces);
        $this->loader->register();
    }

    /**
     * Register files.
     */
    protected function registerFiles()
    {
        $files = [
            CONFIG_DIR . 'helper.php',
        ];
        $this->loader->registerFiles($files);
        $this->loader->register();
    }
}
