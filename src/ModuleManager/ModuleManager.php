<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 9/23/14
 * Time: 10:01 PM
 */

namespace Bluz\ModuleManager;

use Bluz\ModuleManager\Exception\ModuleNotFoundException;
use Bluz\ModuleManager\Exception\ModuleNotRegisteredException;
use Bluz\ServiceManager\ServiceManager;

/**
 * Class ModuleManager - manager and loader of all Application Modules
 * @package Bluz\ModuleManager
 */
class ModuleManager
{
    /** @var array  */
    protected $loadedModules = [];

    /** @var array  */
    protected $modules = [];

    /** @var array  */
    protected $config = [];

    /** @var ServiceManager */
    protected $serviceManager;

    /** @var bool  */
    protected $loaded = false;

    /**
     * Initialise ModuleManager by Array of active Modules and base config
     * @param array $modules an array of Modules that we need to load
     * @param ServiceManager $serviceManager
     */
    public function __construct(array $modules, ServiceManager $serviceManager)
    {
        $this->setModules($modules);
        $this->serviceManager = $serviceManager;
    }

    /**
     * Returns an array of Modules names
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * Setting an array of modules
     * @param array $modules
     * @return $this
     */
    public function setModules(array $modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * Returns an config after loading Modules
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Get Module Instance by Namespace name
     * @param $moduleName
     * @return object
     * @throws ModuleNotFoundException
     */
    public function getModule($moduleName)
    {
        return $this->loadModule($moduleName);
    }

    /**
     * Load Module by Namespace
     * @param $module
     * @throws ModuleNotFoundException
     * @throws ModuleNotRegisteredException
     * @return object
     */
    public function loadModule($module)
    {
        if (!in_array($module, $this->modules)) {
            throw new ModuleNotRegisteredException(
                'Module ' . $module . ' not registered in ModuleManager. Update your config'
            );
        }
        if (isset($this->loadedModules[$module])) {
            return $this->loadedModules[$module];
        }

        $className = $module . '\Module';

        if (class_exists($className)) {
            $instance = new $className();
            if (method_exists($instance, 'getConfig')) {
                $this->addConfig(
                    $instance->getConfig()
                );
            }

            $this->loadedModules[$module] = $instance;

            return $instance;
        } else {
            throw new ModuleNotFoundException(
                'Module ' . $module . ' not found'
            );
        }
    }

    /**
     * Set config
     * @param array $config
     * @return $this
     */
    public function addConfig($config)
    {
        $this->config = array_replace_recursive($this->config, $config);
        $this->serviceManager->setService('Config', $this->config);
        if (isset($config['service_manager'])) {
            $this->serviceManager->getServiceManagerConfig()->setServiceManagerConfig($config['service_manager']);
        }

        return $this;
    }

    /**
     * Load all modules that currently added to ModuleManager
     * @return $this
     */
    public function loadModules()
    {
        if ($this->isLoaded()) {
            return $this;
        }

        foreach ($this->modules as $module) {
            $this->loadModule($module);
        }
        $this->setLoaded(true);

        return $this;
    }

    /**
     * Checks is modules already loaded
     * @return boolean
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * Sets status of loading
     * @param boolean $loaded
     * @return $this
     */
    public function setLoaded($loaded)
    {
        $this->loaded = $loaded;
        return $this;
    }
} 