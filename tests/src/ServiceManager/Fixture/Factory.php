<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 2:29
 */

namespace Bluz\Tests\ServiceManager\Fixture;


use Bluz\ServiceManager\FactoryInterface;
use Bluz\ServiceManager\ServiceManager;

class Factory implements FactoryInterface
{
    /**
     * Create an instance of Service
     * @param ServiceManager $serviceManager
     * @return object
     */
    public function getService(ServiceManager $serviceManager)
    {
        return new \ArrayObject();
    }
}