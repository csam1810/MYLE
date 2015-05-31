<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Recipe\Model\Recipe;
 use Recipe\Model\IngredientsOfRecipe;
 use Zend\InputFilter\InputFilter;

 class RecipeController extends AbstractActionController
 {
     protected $recipeTable;
     protected $ingredientTable;
     protected $ingredientsOfRecipeTable;
     protected $weightUnitsTable;
     protected $difficultiesTable;
     
     public function getDifficultiesTable()
     {
         if (!$this->difficultiesTable) {
             $sm = $this->getServiceLocator();
             $this->difficultiesTable = $sm->get('Recipe\Model\DifficultiesTable');
         }
         return $this->difficultiesTable;
     }
     
     public function getWeightUnitsTable()
     {
         if (!$this->weightUnitsTable) {
             $sm = $this->getServiceLocator();
             $this->weightUnitsTable = $sm->get('Recipe\Model\WeightUnitsTable');
         }
         return $this->weightUnitsTable;
     }
     
     public function getIngredientTable()
     {
         if (!$this->ingredientTable) {
             $sm = $this->getServiceLocator();
             $this->ingredientTable = $sm->get('Recipe\Model\IngredientTable');
         }
         return $this->ingredientTable;
     }
     
     public function getIngredientsOfRecipeTable()
     {
         if (!$this->ingredientsOfRecipeTable) {
             $sm = $this->getServiceLocator();
             $this->ingredientsOfRecipeTable = $sm->get('Recipe\Model\IngredientsOfRecipeTable');
         }
         return $this->ingredientsOfRecipeTable;
     }
     
     public function getRecipeTable()
     {
         if (!$this->recipeTable) {
             $sm = $this->getServiceLocator();
             $this->recipeTable = $sm->get('Recipe\Model\RecipeTable');
         }
         return $this->recipeTable;
     }
     
     public function indexAction()
     {
         $recipeEntities = $this->getRecipeTable()->fetchAll();
         //containers
         $recipes = array();
         $difficulties = array();
         foreach($recipeEntities as $recipe) {
             $recipes[$recipe->recipeID] = $recipe;
             $difficulties[$recipe->recipeID] = $this->getDifficultiesTable()->getDifficultyName($recipe->difficultyID);
         }
         return new ViewModel(array(
             'recipes' => $recipes, 'difficulties' => $difficulties,
         ));
     }

     public function createRecipeAction() {
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Recipe\Form\CreateRecipeForm');

        //$form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $recipe = new Recipe();
            $form->setInputFilter($recipe->getInputFilter());
            $form->setData($request->getPost());

            //check if data needed for recipe creation is valid
            if ($form->isValid()) {
                $recipe->exchangeArray($form->getData());
                //TODO: move following line (maybe to the validator in recipe.php?)
                $recipe->difficultyID = $recipe->difficultyID['difficultyID'];
                $id = $this->getRecipeTable()->saveRecipe($recipe);

                foreach ($form->get('ingredients') as $ingredientFieldset) {
                    $ingredientID = $ingredientFieldset->get('ingredientID')->get('ingredientID')->getValue();
                    $amount = $ingredientFieldset->get('ingredientAmount')->getValue();
                    $ingredient = new IngredientsOfRecipe();

                    $ingredient->exchangeArray(array('amount' => $amount,
                        'weightUnitID' => $ingredientFieldset->get('weightUnit')->get('unitName')->getValue(),
                        'ingredientID' => $ingredientID,
                        'recipeID' => $id));

                    $this->getIngredientsOfRecipeTable()->saveIngredientsOfRecipe($ingredient);
                }

                return $this->redirect()->toRoute('recipe', array('action' => 'detailedView', 'recipeID' => $id));
            }
        } else {
            //echo "recipe is not valid!";
        }
        
        return array('form' => $form);
    }

    /* CV: getRecipesByName
      */
       public function getSearchResultAction()
     {
           /*
         $recipeEntities = $this->getRecipeTable()->getRecipeByName();
         //containers
         $recipes = array();
         $difficulties = array();
         foreach($recipeEntities as $recipe) {
             $recipes[$recipe->recipeID] = $recipe;
             $difficulties[$recipe->recipeID] = $this->getDifficultiesTable()->getDifficultyName($recipe->difficultyID);
         }
         return new ViewModel(array(
             'recipes' => $recipes, 'difficulties' => $difficulties,
         ));*/
     }
     

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
     
     public function detailedViewAction() {
         //get id of recipe to be shown in detail
         $recipeID = (int) $this->params()->fromRoute('recipeID');
         
         $difficulty = $this->getDifficultiesTable()->getDifficultyName($this->getRecipeTable()->getRecipe($recipeID)->difficultyID);
         //get all ingredient ids + amounts + weight unit ids associated with given recipe id
         $ingredientsOfRecipe = $this->getIngredientsOfRecipeTable()->getIngredientsForRecipe($recipeID);
         //we need another container for the elements returned by the DB, since Zend allows only one traversal of the returned set
         $ingredients = array();
         //declaration of containers for additional ingredient information (name, weight unit)
         $ingredientNames = array();
         $ingredientWeightUnits = array();
         //get all ingredient names for all ids
         foreach($ingredientsOfRecipe as $ingredient) {
             $ingredients[$ingredient->ingredientID] = $ingredient;
             $ingredientID = $ingredient->ingredientID;
             $ingredientNames[$ingredientID] = $this->getIngredientTable()->getIngredientName($ingredientID);
             if(!isset($ingredientWeightUnits[$ingredient->weightUnitID])) {
                 $ingredientWeightUnits[$ingredient->weightUnitID] = $this->getWeightUnitsTable()->getWeightUnitName($ingredient->weightUnitID);
             }
         }
         //give data to view
         return new ViewModel(array('recipe' => $this->getRecipeTable()->getRecipe($recipeID), 
             'difficulty' => $difficulty,
             'ingredientsOfRecipe' => $ingredients, 'ingredientNames' => $ingredientNames,
             'weightUnits' => $ingredientWeightUnits));
     }
 }