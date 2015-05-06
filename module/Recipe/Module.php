<?php

namespace Recipe;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
 // Add these import statements:
 use Recipe\Model\Recipe;
 use Recipe\Model\RecipeTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;


 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
     public function getAutoloaderConfig()
     {
         return array(
             'Zend\Loader\ClassMapAutoloader' => array(
                 __DIR__ . '/autoload_classmap.php',
             ),
             'Zend\Loader\StandardAutoloader' => array(
                 'namespaces' => array(
                     __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                 ),
             ),
         );
     }

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }
     
     // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Recipe\Model\RecipeTable' =>  function($sm) {
                     $tableGateway = $sm->get('RecipeTableGateway');
                     $table = new RecipeTable($tableGateway);
                     return $table;
                 },
                 'RecipeTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Recipe());
                     return new TableGateway('Recipe', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }
