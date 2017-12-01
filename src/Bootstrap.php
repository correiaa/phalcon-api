<?php

namespace App;

use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;

/**
 * Application.
 *
 * @package App
 */
class Application
{
    /** @var \Phalcon\Di\FactoryDefault $factoryDefault */
    private $factoryDefault;

    /** @var \Phalcon\Loader $loader */
    private $loader;

    /**
     * Application constructor.
     *
     * @param \Phalcon\Di\FactoryDefault $factoryDefault
     * @param \Phalcon\Loader            $loader
     */
    public function __construct(FactoryDefault $factoryDefault, Loader $loader)
    {
        $this->factoryDefault = $factoryDefault;
        $this->loader = $loader;
    }

    public function main()
    {
        $this->registerNamespaces();
        $this->registerDirs();
    }

    protected function registerDirs()
    {
        $config = $this->factoryDefault->get('config');
        $directories = [
            $config->application->componentsDir,
            $config->application->controllersDir,
            $config->application->eventsDir,
            $config->application->modelsDir,
            $config->application->traitsDir,
        ];
        $this->loader->registerDirs($directories);
        $this->loader->register();
    }

    protected function registerNamespaces()
    {
        $namespaces = [
            'App\\Component'  => '../src/components',
            'App\\Controller' => '../src/controllers',
            'App\\Event'      => '../src/events',
            'App\\Model'      => '../src/models',
            'App\\Traits'     => '../src/traits',
        ];
        $this->loader->registerNamespaces($namespaces);
        $this->loader->register();
    }

    protected function registerServices()
    {
        $this->factoryDefault->setShared($name, $definition);
    }
}
