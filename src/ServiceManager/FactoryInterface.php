<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 1:48
 */

namespace Bluz\ServiceManager;


interface FactoryInterface
{
    /**
     * Create an instance of Service
     * @param ServiceManager $serviceManager
     * @return object
     */
    public function getService(ServiceManager $serviceManager);
} 