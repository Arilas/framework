<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 2:45
 */

namespace Bluz\Tests\ServiceManager\Fixture;


use Bluz\ServiceManager\AbstractFactoryInterface;
use Bluz\ServiceManager\ServiceManager;

class AbstractFactory implements AbstractFactoryInterface
{

    public function canCreateService(ServiceManager $serviceManager, $name)
    {
        return ($name == 'Config');
    }

    public function getService(ServiceManager $serviceManager, $name)
    {
        return new \ArrayObject();
    }
}