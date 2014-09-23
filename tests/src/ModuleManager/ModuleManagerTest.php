<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 0:53
 */

namespace Bluz\Tests\ModuleManager;

use Bluz\ModuleManager\ModuleManager;

class ModuleManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testInstance()
    {
        $moduleManager = new ModuleManager([]);
        $moduleManager->loadModules();
        $this->assertTrue($moduleManager->isLoaded());
        $this->assertEmpty($moduleManager->getModules());
    }

    public function testLoading()
    {
        $moduleManager = new ModuleManager(['BluzTest\Application']);
        $moduleManager->loadModules();
        $this->assertInstanceOf('BluzTest\Application\Module', $moduleManager->getModule('BluzTest\Application'));
        $this->assertCount(1, $moduleManager->getConfig());
        $this->assertArrayHasKey('application', $moduleManager->getConfig());
    }

    /**
     * @expectedException \Bluz\ModuleManager\Exception\ModuleNotRegisteredException
     */
    public function testNotRegistered()
    {
        $moduleManager = new ModuleManager([]);
        $moduleManager->loadModule('BluzTest\Application');
    }

    /**
     * @expectedException \Bluz\ModuleManager\Exception\ModuleNotFoundException
     */
    public function testThrow()
    {
        $moduleManager = new ModuleManager(['BluzTest']);
        $moduleManager->loadModule('BluzTest');
    }
}
 