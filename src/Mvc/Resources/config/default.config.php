<?php
/**
 * Created by PhpStorm.
 * User: krona
 * Date: 24.09.14
 * Time: 3:44
 */
return [
    'service_manager' => [
        'invokables' => [
            'ModuleManager' => function (\Bluz\ServiceManager\ServiceManager $serviceManager) {
                $applicationConfig = $serviceManager->get('ApplicationConfig');
                return new \Bluz\ModuleManager\ModuleManager($applicationConfig['modules'], $serviceManager);
            },
            'Application' => function (\Bluz\ServiceManager\ServiceManager $serviceManager) {
                return new \Bluz\Mvc\Application($serviceManager);
            }
        ],
        'factories' => [
            'Request' => 'Bluz\Request\Service\RequestFactory',
            'Response' => 'Bluz\Request\Service\ResponseFactory',
        ],
    ],
];