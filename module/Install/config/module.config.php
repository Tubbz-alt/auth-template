<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Install;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/install',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'install',
                    ],
                ],
            ],
            'install' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/install[/:action]',
                    'defaults' => [
                        'controller' => Controller\InstallController::class,
                        'action'     => 'install',
                    ],
                ],
            ],
            'crud' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/crud[/:action]',
                    'defaults' => [
                        'controller' => Controller\CrudController::class,
                        'action'     => 'read',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\InstallController::class => InvokableFactory::class,
            Controller\CrudController::class => InvokableFactory::class, 
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    'service_manager' => [
        'factories' => [
            // ...
        ],
    ],
];
