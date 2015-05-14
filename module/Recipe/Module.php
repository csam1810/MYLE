<?php

namespace Recipe;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 
 use Recipe\Model\Recipe;
 use Recipe\Model\RecipeTable;
 use Recipe\Model\Ingredient;
 use Recipe\Model\IngredientTable;
 use Recipe\Model\IngredientsOfRecipe;
 use Recipe\Model\IngredientsOfRecipeTable;
 use Recipe\Model\WeightUnits;
 use Recipe\Model\WeightUnitsTable;
 use Recipe\Model\Difficulties;
 use Recipe\Model\DifficultiesTable;
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
                 'Recipe\Model\IngredientTable' =>  function($sm) {
                     $tableGateway = $sm->get('IngredientTableGateway');
                     $table = new IngredientTable($tableGateway);
                     return $table;
                 },
                 'IngredientTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Ingredient());
                     return new TableGateway('Ingredient', $dbAdapter, null, $resultSetPrototype);
                 }, 
                 'Recipe\Model\IngredientsOfRecipeTable' =>  function($sm) {
                     $tableGateway = $sm->get('IngredientsOfRecipeTableGateway');
                     $table = new IngredientsOfRecipeTable($tableGateway);
                     return $table;
                 },
                 'IngredientsOfRecipeTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new IngredientsOfRecipe());
                     return new TableGateway('IngredientsOfRecipe', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Recipe\Model\WeightUnitsTable' =>  function($sm) {
                     $tableGateway = $sm->get('WeightUnitsTableGateway');
                     $table = new WeightUnitsTable($tableGateway);
                     return $table;
                 },
                 'WeightUnitsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new WeightUnits());
                     return new TableGateway('WeightUnits', $dbAdapter, null, $resultSetPrototype);
                 },
                 'Recipe\Model\DifficultiesTable' =>  function($sm) {
                     $tableGateway = $sm->get('DifficultiesTableGateway');
                     $table = new DifficultiesTable($tableGateway);
                     return $table;
                 },
                 'DifficultiesTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Difficulties());
                     return new TableGateway('Difficulties', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }
