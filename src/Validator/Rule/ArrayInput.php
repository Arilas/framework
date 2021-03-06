<?php
/**
 * Bluz Framework Component
 *
 * @copyright Bluz PHP Team
 * @link https://github.com/bluzphp/framework
 */

/**
 * @namespace
 */
namespace Bluz\Validator\Rule;

use Bluz\Validator\Exception\ComponentException;

/**
 * Class ArrayInput
 * @package Bluz\Validator\Rule
 */
class ArrayInput extends AbstractRule
{
    /**
     * @var string
     */
    protected $template = '{{name}} must be a array';

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @param callable $callback
     * @throws ComponentException
     */
    public function __construct($callback)
    {
        if (!is_callable($callback)) {
            throw new ComponentException(
                __('"%s" is not a valid callable structure', $callback)
            );
        }

        $this->callback = $callback;
    }

    /**
     * @param string $input
     * @return bool
     */
    public function validate($input)
    {
        if (!is_array($input)) {
            return false;
        }
        $filtered = array_filter($input, $this->callback);
        return sizeof($input) == sizeof($filtered);
    }
}
