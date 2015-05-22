<?php

namespace Createaccount;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
 // Add these import statements:
 use Createaccount\Model\Createaccount;
 use Createaccount\Model\CreateaccountTable;
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
                 'Createaccount\Model\CreateaccountTable' =>  function($sm) {
                     $tableGateway = $sm->get('CreateAccountTableGateway');
                     $table = new CreateaccountTable($tableGateway);
                     return $table;
                 },
                 'CreateaccountTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Createaccount());
                     return new TableGateway('User', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }
