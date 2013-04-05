<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/Project for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Project;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Project\Model\Project;
use Project\Model\ProjectTable;
use Project\Model\ProjectPartTable;
use Project\Model\workpackage;
use Project\Model\workpackageTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module implements AutoloaderProviderInterface
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Project\Model\ProjectPartTable' =>  function($sm) {
    						$tableGateway = $sm->get('ProjectPartTableGateway');
    						$table = new ProjectPartTable($tableGateway);
    						return $table;
    					},
    					'ProjectPartTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Project());
    						return new TableGateway('projectpart', $dbAdapter, null, $resultSetPrototype);
    					},
    					'Project\Model\workpackageTable' =>  function($sm) {
    						$tableGateway = $sm->get('workpackageTableGateway');
    						$table = new workpackageTable($tableGateway);
    						return $table;
    					},
    					'workpackageTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new workpackage());
    						return new TableGateway('workpackage', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }

    public function onBootstrap($e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
}
