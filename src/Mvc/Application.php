<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 3:39
 */

namespace Bluz\Mvc;


use Bluz\ServiceManager\ServiceManager;
use Bluz\ServiceManager\ServiceManagerConfig;

class Application
{
    protected $debug = true;

    protected $request;

    protected $response;

    /** @var ServiceManager */
    protected $serviceManager;

    public function __construct(ServiceManager $serviceManager)
    {
        $this->setServiceManager($serviceManager);
        $this->setup();
    }

    protected function setup()
    {
        $config = $this->serviceManager->get('Config');
        if (isset($config['debug'])) {
            $this->setDebug($config['debug']);
        }
    }

    /**
     * Creates instance of Application
     * @param array $configuration
     * @return $this
     * @throws \Bluz\ServiceManager\Exception\ServiceNotFoundException
     */
    public static function init(array $configuration = [])
    {
        $defaultConfig = include_once __DIR__ . '/Resources/config/default.config.php';
        $configuration = array_replace($defaultConfig, $configuration);
        $serviceManagerConfig = new ServiceManagerConfig($configuration);
        $serviceManager = new ServiceManager($serviceManagerConfig);
        $serviceManager->setService('ApplicationConfig', $configuration);
        $serviceManager->get('ModuleManager')->loadModules();
        return $serviceManager->get('Application')->bootstrap();
    }

    public function bootstrap()
    {
        return $this;
    }

    /**
     * @return boolean
     */
    public function isDebug()
    {
        return $this->debug;
    }

    /**
     * @param boolean $debug
     */
    public function setDebug($debug)
    {
        $this->debug = $debug;
    }

    /**
     * @return ServiceManager
     */
    public function getServiceManager()
    {
        return $this->serviceManager;
    }

    /**
     * @param ServiceManager $serviceManager
     */
    public function setServiceManager($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
} 