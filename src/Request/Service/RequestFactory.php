<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 4:13
 */

namespace Bluz\Request\Service;


use Bluz\Cli\Request as CliRequest;
use Bluz\Http\Request as HttpRequest;
use Bluz\ServiceManager\FactoryInterface;
use Bluz\ServiceManager\ServiceManager;

class RequestFactory implements FactoryInterface
{
    /**
     * Create an instance of Service
     * @param ServiceManager $serviceManager
     * @return CliRequest|HttpRequest
     */
    public function getService(ServiceManager $serviceManager)
    {
        if (PHP_SAPI === 'cli') {
            return new CliRequest();
        } else {
            return new HttpRequest();
        }
    }
}