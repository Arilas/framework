<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 9/23/14
 * Time: 10:01 PM
 */

namespace Bluz\ModuleManager;

/**
 * Class ModuleManager -
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

    /** @var bool  */
    protected $loaded = false;

    /**
     *
     * @param array $modules  an array of Modules that we need to load
     * @param array $config   an array of Config, that used for merging config to
     */
    public function __construct(array $modules, array $config = [])
    {
        $this
            ->setModules($modules)
            ->setConfig($config)
        ;
    }

    /**
     * @param array $modules
     * @return $this
     */
    public function setModules(array $modules)
    {
        $this->modules = $modules;

        return $this;
    }

    /**
     * @return array
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function setConfig($config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * @return $this
     */
    public function loadModules()
    {
        if ($this->isLoaded()) {
            return $this;
        }

        return $this;
    }

    /**
     * @param $module
     * @return object
     */
    public function loadModule($module)
    {

    }

    /**
     * @return boolean
     */
    public function isLoaded()
    {
        return $this->loaded;
    }

    /**
     * @param boolean $loaded
     * @return $this
     */
    public function setLoaded($loaded)
    {
        $this->loaded = $loaded;
        return $this;
    }
} 