<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'World\Controller\World' => 'World\Controller\WorldController',
            'World\Controller\Country' => 'World\Controller\CountryController',
            'World\Controller\City' => 'World\Controller\CityController',
            'World\Controller\Area' => 'World\Controller\AreaController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'world' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/world[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'World\Controller\World',
                        'action'     => 'index',
                    ),
                ),
            ),
            'country' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/country[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'World\Controller\Country',
                        'action'     => 'index',
                    ),
                ),
            ),
            'city' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/city[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'World\Controller\City',
                        'action'     => 'index',
                    ),
                ),
            ),
            'area' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/area[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'World\Controller\Area',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'world' => __DIR__ . '/../view',
        ),
    ),
);