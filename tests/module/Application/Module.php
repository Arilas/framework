<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 0:51
 */

namespace BluzTest\Application;


class Module
{
    public function getConfig()
    {
        return [
            'application' => [
                'title' => 'Bluz',
            ],
        ];
    }
} 