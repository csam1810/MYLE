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
 use Recipe\Model\Lists;                    
 use Recipe\Model\ListsTable;               
 use Recipe\Model\ListDetail;               
 use Recipe\Model\ListDetailTable;          
 use Recipe\Form\DifficultyFieldset;
 use Recipe\Form\IngredientNameFieldset;
 use Recipe\Form\WeightUnitFieldset;
 use Recipe\Form\IngredientFieldset;

 
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;
 use Zend\ModuleManager\Feature\FormElementProviderInterface;

 class Module implements AutoloaderProviderInterface, ConfigProviderInterface, FormElementProviderInterface
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
                 'Recipe\Model\ListsTable' =>  function($sm) {
                     $tableGateway = $sm->get('ListsTableGateway');
                     $table = new ListsTable($tableGateway);
                     return $table;
                 },                 
                 'ListsTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Lists());
                     return new TableGateway('Lists', $dbAdapter, null, $resultSetPrototype);
                 },                 
                  'Recipe\Model\ListDetailTable' =>  function($sm) {
                     $tableGateway = $sm->get('ListDetailTableGateway');
                     $table = new ListDetailTable($tableGateway);
                     return $table;
                 },                 
                 'ListDetailTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new ListDetail());
                     return new TableGateway('ListDetail', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

    public function getFormElementConfig() {
        return array(
            'factories' => array(
                'DifficultyFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $difficultyTable = $serviceLocator->get('Recipe\Model\DifficultiesTable');
                    $fieldset = new DifficultyFieldset($difficultyTable);
                    return $fieldset;
                },
                'IngredientNameFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $ingredientTable = $serviceLocator->get('Recipe\Model\IngredientTable');
                    $fieldset = new IngredientNameFieldset($ingredientTable);
                    return $fieldset;
                },
                'WeightUnitFieldset' => function($sm) {
                    $serviceLocator = $sm->getServiceLocator();
                    $weightUnitTable = $serviceLocator->get('Recipe\Model\WeightUnitsTable');
                    $fieldset = new WeightUnitFieldset($weightUnitTable);
                    return $fieldset;
                },
                'IngredientFieldset' => function($sm) {
                    $fieldset = new IngredientFieldset();
                    return $fieldset;
                },
            )
        );
    }

}
