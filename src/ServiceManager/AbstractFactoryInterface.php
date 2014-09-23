<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 1:49
 */

namespace Bluz\ServiceManager;


interface AbstractFactoryInterface
{
    public function canCreateService(ServiceManager $serviceManager, $name);

    public function getService(ServiceManager $serviceManager, $name);
} 