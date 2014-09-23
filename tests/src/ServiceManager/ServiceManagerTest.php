<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 2:21
 */

namespace Bluz\Tests\ServiceManager;

use Bluz\ServiceManager\ServiceManager;
use Bluz\ServiceManager\ServiceManagerConfig;

class ServiceManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig()
        );

        $this->assertFalse($serviceManager->has('orm'));
    }

    public function testCallableInvokable()
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig()
        );

        $serviceManager->getServiceManagerConfig()->setServiceManagerConfig([
            'aliases' => [
                'array' => 'Config',
            ],
            'invokables' => [
                'Config' => function () {
                    return new \ArrayObject();
                }
            ],
        ]);
        /** @var \ArrayObject $config */
        $config = $serviceManager->get('array');
        $this->assertInstanceOf('ArrayObject', $config);
        $this->assertEmpty($config);
        $config['application'] = 'test';
        $this->assertCount(1, $serviceManager->get('array'));
    }

    public function testClassInvokable()
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig()
        );

        $serviceManager->getServiceManagerConfig()->setServiceManagerConfig([
            'aliases' => [
                'array' => 'Config',
            ],
            'invokables' => [
                'Config' => 'Bluz\Tests\ServiceManager\Fixture\Invokable',
            ],
        ]);
        /** @var \ArrayObject $config */
        $config = $serviceManager->get('array');
        $this->assertInstanceOf('ArrayObject', $config);
        $this->assertEmpty($config);
        $config['application'] = 'test';
        $this->assertCount(1, $serviceManager->get('array'));
    }

    public function testFactory()
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig()
        );

        $serviceManager->getServiceManagerConfig()->setServiceManagerConfig([
            'aliases' => [
                'array' => 'Config',
            ],
            'factories' => [
                'Config' => 'Bluz\Tests\ServiceManager\Fixture\Factory'
            ],
        ]);
        /** @var \ArrayObject $config */
        $config = $serviceManager->get('array');
        $this->assertInstanceOf('ArrayObject', $config);
        $this->assertEmpty($config);
        $config['application'] = 'test';
        $this->assertCount(1, $serviceManager->get('array'));
    }

    public function testAbstractFactory()
    {
        $serviceManager = new ServiceManager(
            new ServiceManagerConfig()
        );

        $serviceManager->getServiceManagerConfig()->setServiceManagerConfig([
            'aliases' => [
                'array' => 'Config',
            ],
            'abstract_factories' => [
                'Bluz\Tests\ServiceManager\Fixture\AbstractFactory'
            ],
        ]);
        /** @var \ArrayObject $config */
        $config = $serviceManager->get('array');
        $this->assertInstanceOf('ArrayObject', $config);
        $this->assertEmpty($config);
        $config['application'] = 'test';
        $this->assertCount(1, $serviceManager->get('array'));
    }
}
 