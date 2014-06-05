<?php
/**
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\Tests\Validator\Rule;

use Bluz\Tests;
use Bluz\Validator\Rule\Alpha;

/**
 * Class AlphaTest
 * @package Bluz\Tests\Validator\Rule
 */
class AlphaTest extends Tests\TestCase
{
    /**
     * @dataProvider providerForValidAlpha
     */
    public function testValidAlphanumericCharsShouldReturnTrue($validAlpha, $additional)
    {
        $validator = new Alpha($additional);
        $this->assertTrue($validator->validate($validAlpha));
    }

    /**
     * @dataProvider providerForInvalidAlpha
     */
    public function testInvalidAlphanumericCharsShouldReturnFalse($invalidAlpha, $additional)
    {
        $validator = new Alpha($additional);
        $this->assertFalse($validator->validate($invalidAlpha));
    }

    /**
     * @dataProvider providerForInvalidParams
     * @expectedException \Bluz\Validator\Exception\ComponentException
     */
    public function testInvalidConstructorParamsShouldThrowComponentException($additional)
    {
        new Alpha($additional);
    }

    /**
     * @dataProvider providerAdditionalChars
     */
    public function testAdditionalCharsShouldBeRespected($additional, $query)
    {
        $validator = new Alpha($additional);
        $this->assertTrue($validator->validate($query));
    }

    /**
     * @return array
     */
    public function providerAdditionalChars()
    {
        return array(
            array('!@#$%^&*(){}', '!@#$%^&*(){} abc'),
            array('[]?+=/\\-_|"\',<>.', "[]?+=/\\-_|\"',<>. \t \n abc"),
        );
    }

    /**
     * @return array
     */
    public function providerForInvalidParams()
    {
        return array(
            array(new \stdClass),
            array(array()),
            array(0x2)
        );
    }

    /**
     * @return array
     */
    public function providerForValidAlpha()
    {
        return array(
            array('', ''),
            array('foobar', ''),
            array('foobar', 'foobar'),
            array('0alg-anet0', '0-9'),
            array('a', ''),
            array("\t", ''),
            array("\n", ''),
            array('foobar', ''),
            array('python_', '_'),
            array('google.com.ua', '.'),
            array('foobar foobar', ''),
            array("\nabc", ''),
            array("\tdef", ''),
            array("\nabc \t", ''),
        );
    }

    /**
     * @return array
     */
    public function providerForInvalidAlpha()
    {
        return array(
            array('@#$', ''),
            array('_', ''),
            array('dgç', ''),
            array('122al', ''),
            array('122', ''),
            array(11123, ''),
            array(1e21, ''),
            array(0, ''),
            array(null, ''),
            array(new \stdClass, ''),
            array(array(), ''),
        );
    }
}
