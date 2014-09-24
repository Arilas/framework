<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 1:20
 */

namespace Bluz\ServiceManager;

use Bluz\ServiceManager\Exception\FactoryNotFoundException;
use Bluz\ServiceManager\Exception\ServiceNotFoundException;
use Bluz\ServiceManager\Exception\WrongFactoryException;


class ServiceManager implements ServiceManagerInterface
{
    /** @var array */
    protected $instances = [];
    /** @var AbstractFactoryInterface[] */
    protected $abstractFactories = [];
    /** @var ServiceManagerConfig */
    protected $serviceManagerConfig;

    public function __construct(ServiceManagerConfig $serviceManagerConfig)
    {
        $this->serviceManagerConfig = $serviceManagerConfig;
    }

    /**
     * @return ServiceManagerConfig
     */
    public function getServiceManagerConfig()
    {
        return $this->serviceManagerConfig;
    }

    /**
     * @param string $alias
     * @throws FactoryNotFoundException
     * @throws ServiceNotFoundException
     * @throws WrongFactoryException
     * @return object
     */
    public function get($alias)
    {
        if ($this->serviceManagerConfig->hasAlias($alias)) {
            $alias = $this->serviceManagerConfig->getByAlias($alias);
        }
        if (isset($this->instances[$alias])) {
            return $this->instances[$alias];
        }
        $service = null;
        if ($this->serviceManagerConfig->hasInvokable($alias)) {
            $service = $this->createServiceViaInvokable($alias);
        } elseif ($this->serviceManagerConfig->hasFactory($alias)) {
            $service = $this->createServiceViaFactory($alias);
        } elseif ($this->canAbstractFactoriesCreate($alias)) {
            $service = $this->createServiceViaAbstractFactories($alias);
        }

        if (is_null($service)) {
            throw new ServiceNotFoundException(
                'Service with name ' . $alias . ' cannot be created'
            );
        }

        $this->processListeners($service);
        $this->instances[$alias] = $service;

        return $service;
    }

    /**
     * @param string $invokableName
     * @return object
     * @throws ServiceNotFoundException
     */
    protected function createServiceViaInvokable($invokableName)
    {
        $invokable = $this->serviceManagerConfig->getInvokable($invokableName);

        if (is_callable($invokable)) {
            $service = $invokable($this);
            return $service;
        } elseif (class_exists($invokable)) {
            $service = new $invokable();
            return $service;
        } else {
            throw new ServiceNotFoundException(
                'Service with name ' . $invokableName . ' not found'
            );
        }
    }

    /**
     * @param string $serviceName
     * @return object
     * @throws FactoryNotFoundException
     * @throws WrongFactoryException
     */
    protected function createServiceViaFactory($serviceName)
    {
        $factory = $this->serviceManagerConfig->getFactory($serviceName);

        if (class_exists($factory)) {
            $factory = new $factory();

            if ($factory instanceof FactoryInterface) {
                return $factory->getService($this);
            } else {
                throw new WrongFactoryException(
                    'Factory for ' . $serviceName . ' must implement FactoryInterface'
                );
            }
        } else {
            throw new FactoryNotFoundException(
                'Factory with class name ' . $factory . ' not found'
            );
        }
    }

    /**
     * @param $name
     * @return bool
     * @throws FactoryNotFoundException
     * @throws ServiceNotFoundException
     */
    protected function canAbstractFactoriesCreate($name)
    {
        if (isset($this->instances[$name])) {
            return true;
        }

        foreach ($this->serviceManagerConfig->getAbstractFactories() as $factoryName) {
            $abstractFactory = $this->getAbstractFactory($factoryName);
            $result = $abstractFactory->canCreateService($this, $name);
            if ($result) {
                return true;
            }
        }

        throw new ServiceNotFoundException(
            'Service with name ' . $name . ' not found'
        );
    }

    /**
     * @param string $factoryName
     * @return AbstractFactoryInterface
     * @throws FactoryNotFoundException
     */
    protected function getAbstractFactory($factoryName)
    {
        if (isset($this->abstractFactories[$factoryName])) {
            return $this->abstractFactories[$factoryName];
        }

        if (class_exists($factoryName)) {
            $this->abstractFactories[$factoryName] = new $factoryName();

            return $this->abstractFactories[$factoryName];
        } else {
            throw new FactoryNotFoundException(
                'Abstract Factory with class ' . $factoryName . ' not found'
            );
        }
    }

    /**
     * @param $name
     * @return bool
     * @throws FactoryNotFoundException
     * @throws ServiceNotFoundException
     */
    protected function createServiceViaAbstractFactories($name)
    {
        if (isset($this->instances[$name])) {
            return true;
        }

        foreach ($this->serviceManagerConfig->getAbstractFactories() as $factoryName) {
            $abstractFactory = $this->getAbstractFactory($factoryName);
            $result = $abstractFactory->canCreateService($this, $name);
            if ($result) {
                return $abstractFactory->getService($this, $name);
            }
        }

        throw new ServiceNotFoundException(
            'Service with name ' . $name . ' not found'
        );
    }

    protected function processListeners($service)
    {
        return $service;
    }

    public function setService($name, $service)
    {
        $this->instances[$name] = $service;

        return $this;
    }

    /**
     * Method used for checks if some Service exists in ServiceManager by name or alias
     * @param string $name
     * @return bool
     * @throws FactoryNotFoundException
     */
    public function has($name)
    {
        try {
            return
                $this->hasInstance($name)
                || $this->serviceManagerConfig->hasAlias($name)
                || $this->serviceManagerConfig->hasFactory($name)
                || $this->canAbstractFactoriesCreate($name);
        } catch (ServiceNotFoundException $e) {
            return false;
        }
    }

    protected function hasInstance($name)
    {
        return (isset($this->instances[$name]));
    }
} 