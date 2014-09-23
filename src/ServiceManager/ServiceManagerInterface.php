<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 1:18
 */

namespace Bluz\ServiceManager;

/**
 * ServiceManagerInterface
 * @package Bluz\ServiceManager
 */
interface ServiceManagerInterface
{
    /**
     * Method used for get Instance of some Service by it's name or alias
     * @param string $name
     * @return object
     */
    public function get($name);

    /**
     * Method used for checks if some Service exists in ServiceManager by name or alias
     * @param string $name
     * @return bool
     */
    public function has($name);
} 