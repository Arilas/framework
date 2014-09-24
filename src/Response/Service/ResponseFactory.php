<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 4:18
 */

namespace Bluz\Response\Service;


use Bluz\Cli\Response as CliResponse;
use Bluz\Http\Response as HttpResponse;
use Bluz\ServiceManager\FactoryInterface;
use Bluz\ServiceManager\ServiceManager;

class ResponseFactory implements FactoryInterface
{
    /**
     * Create an instance of Service
     * @param ServiceManager $serviceManager
     * @return CliResponse|HttpResponse
     */
    public function getService(ServiceManager $serviceManager)
    {
        if (PHP_SAPI === 'cli') {
            return new CliResponse();
        } else {
            return new HttpResponse();
        }
    }
} 