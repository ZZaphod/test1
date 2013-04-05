<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Project\Controller\Project' => 'Project\Controller\ProjectController',
            'Project\Controller\Workpackage' => 'Project\Controller\WorkpackageController',
        ),
    ),
    
    'router' => array(
    		'routes' => array(
    				'project' => array(
    						'type'    => 'segment',
    						'options' => array(
    								'route'    => '/project[/:action][/:id]',
    								'constraints' => array(
    										'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
    										'id'     => '[0-9]+',
    								),
    								'defaults' => array(
    										'controller' => 'Project\Controller\Project',
    										'action'     => 'index',
    								),
    						),
    				),
    		    'workpackage' => array(
    		    		'type'    => 'segment',
    		    		'options' => array(
    		    				'route'    => '/workpackage[/:action][/:id]',
    		    				'constraints' => array(
    		    						'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
    		    						'id'     => '[0-9]+',
    		    				),
    		    				'defaults' => array(
    		    						'controller' => 'Project\Controller\Workpackage',
    		    						'action'     => 'index',
    		    				),
    		    		),
    		    ),
    		),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'project' => __DIR__ . '/../view',
        ),
    ),
);