<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 1:21
 */

namespace Bluz\ServiceManager;

class ServiceManagerConfig
{
    protected $aliases = [];

    protected $invokables = [];

    protected $factories = [];

    protected $abstractFactories = [];

    protected $serviceListeners = [];

    public function __construct(array $config = [])
    {
        if (isset($config['service_manager'])) {
            $this->setServiceManagerConfig($config['service_manager']);
        } else {
            $this->setServiceManagerConfig([]);
        }
    }

    /**
     * @param array $serviceManagerConfig
     * @return $this
     */
    public function setServiceManagerConfig(array $serviceManagerConfig)
    {
        $this->aliases = array_replace(
            $this->aliases,
            isset($serviceManagerConfig['aliases']) ? $serviceManagerConfig['aliases'] : []
        );
        $this->invokables = array_replace(
            $this->invokables,
            isset($serviceManagerConfig['invokables']) ? $serviceManagerConfig['invokables'] : []
        );
        $this->factories = array_replace(
            $this->factories,
            isset($serviceManagerConfig['factories']) ? $serviceManagerConfig['factories'] : []
        );
        $this->abstractFactories = array_replace(
            $this->abstractFactories,
            isset($serviceManagerConfig['abstract_factories']) ? $serviceManagerConfig['abstract_factories'] : []
        );
        $this->serviceListeners = array_replace(
            $this->serviceListeners,
            isset($serviceManagerConfig['service_listeners']) ? $serviceManagerConfig['service_listeners'] : []
        );

        return $this;
    }

    /**
     * @return array
     */
    public function getAbstractFactories()
    {
        return $this->abstractFactories;
    }

    public function hasAlias($alias)
    {
        return (isset($this->aliases[$alias]));
    }

    public function hasInvokable($name)
    {
        return (isset($this->invokables[$name]));
    }

    public function hasFactory($factory)
    {
        return (isset($this->factories[$factory]));
    }

    public function getByAlias($alias)
    {
        return $this->aliases[$alias];
    }

    public function getInvokable($invokableName)
    {
        return $this->invokables[$invokableName];
    }

    public function getFactory($serviceName)
    {
        return $this->factories[$serviceName];
    }
} 