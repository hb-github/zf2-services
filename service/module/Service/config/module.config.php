<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Service\Controller\User',
                        'action'     => 'index',
                    ),
                ),
                
            ),
            'service_orders' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/service_orders[/:action][/:id]',
                    'defaults' => array(
                        'controller' => 'Service\Controller\ServiceOrder',
                        'action'     => 'index',
                    ),
                ),
                
            ),
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Service\Controller\User',
                        'action'     => 'login',
                    ),
                ),
                
            ),
            'brands' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/brands[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Service\Controller\Brands',
                        'action'     => 'index',
                    ),
                ),
                
            ),
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Service\Controller\Index' => 'Service\Controller\IndexController',
            'Service\Controller\Brands' => 'Service\Controller\BrandsController',
            'Service\Controller\User' => 'Service\Controller\UserController',
            'Service\Controller\ServiceOrder' => 'Service\Controller\ServiceOrderController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/top_bar'          => __DIR__ . '/../view/layout/top_bar.phtml',
            'layout/logo_bar'         => __DIR__ . '/../view/layout/logo_bar.phtml',
            'layout/menu_bar'         => __DIR__ . '/../view/layout/menu_bar.phtml',
            'layout/breadcrumb'       => __DIR__ . '/../view/layout/breadcrumb.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
            'layout/login'            => __DIR__ . '/../view/layout/login.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
