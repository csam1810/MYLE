<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class RecipeController extends AbstractActionController
 {
     protected $recipeTable;
     protected $ingredientTable;
     protected $ingredientsOfRecipeTable;
     
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
         return new ViewModel(array(
             'recipes' => $this->getRecipeTable()->fetchAll(),
         ));
     }

     public function addAction()
     {
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }
     
     public function detailedViewAction() {
         $recipeID = (int) $this->params()->fromRoute('recipeID');
         $ingredients = $this->getIngredientsOfRecipeTable()->getIngredientsForRecipe($recipeID);
         return new ViewModel(array('recipe' => $this->getRecipeTable()->getRecipe($recipeID), 'ingredients' => $ingredients));
     }
 }