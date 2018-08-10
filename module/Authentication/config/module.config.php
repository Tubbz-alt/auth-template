<?php
/**
 * @link      https://github.com/dk2103/auth-template
 * @copyright Copyright (c) 2018 MEIKO Maschinenbau GmbH & Co. KG
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 * @author    Daniel Kopf
 */
namespace Meiko\Authentication;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Meiko\Authentication\Factory\AuthenticationServiceFactory;
use Meiko\Authentication\Factory\LoginControllerFactory;
return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'auth' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/auth[/:action]',
                    'defaults' => [
                        'controller' => Controller\LoginController::class,
                        'action' => 'login'
                    ]
                ]
            ],
            'registration' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/registration[/:action]',
                    'defaults' => [
                        'controller' => Controller\RegistrationController::class,
                        'action' => 'register'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\RegistrationController::class => InvokableFactory::class,
            Controller\LoginController::class => LoginControllerFactory::class

        ]
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'not_found_template' => 'error/404',
        'exception_template' => 'error/index',
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml'
        ],
        'template_path_stack' => [
            __DIR__ . '/../view'
        ]
    ],
    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => AuthenticationServiceFactory::class
            // ...
        ]
    ]
];
