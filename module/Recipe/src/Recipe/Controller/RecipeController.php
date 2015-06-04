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
use Recipe\Model\Ingredient;
use Recipe\Model\Lists;                //ins CVL
use Recipe\Model\ListDetail;           //ins CVL
use Zend\InputFilter\InputFilter;
use Recipe\Form\CreateRecipeForm;

class RecipeController extends AbstractActionController {

    protected $recipeTable;
    protected $ingredientTable;
    protected $ingredientsOfRecipeTable;
    protected $weightUnitsTable;
    protected $difficultiesTable;
    protected $listsTable;                     //ins CVL
    protected $listDetailTable;                //ins CVL

    public function getDifficultiesTable() {
        if (!$this->difficultiesTable) {
            $sm = $this->getServiceLocator();
            $this->difficultiesTable = $sm->get('Recipe\Model\DifficultiesTable');
        }
        return $this->difficultiesTable;
    }

    public function getWeightUnitsTable() {
        if (!$this->weightUnitsTable) {
            $sm = $this->getServiceLocator();
            $this->weightUnitsTable = $sm->get('Recipe\Model\WeightUnitsTable');
        }
        return $this->weightUnitsTable;
    }

    public function getIngredientTable() {
        if (!$this->ingredientTable) {
            $sm = $this->getServiceLocator();
            $this->ingredientTable = $sm->get('Recipe\Model\IngredientTable');
        }
        return $this->ingredientTable;
    }

    public function getIngredientsOfRecipeTable() {
        if (!$this->ingredientsOfRecipeTable) {
            $sm = $this->getServiceLocator();
            $this->ingredientsOfRecipeTable = $sm->get('Recipe\Model\IngredientsOfRecipeTable');
        }
        return $this->ingredientsOfRecipeTable;
    }

    public function getRecipeTable() {
        if (!$this->recipeTable) {
            $sm = $this->getServiceLocator();
            $this->recipeTable = $sm->get('Recipe\Model\RecipeTable');
        }
        return $this->recipeTable;
    }

    //CVL ins
    public function getListsTable() {
        if (!$this->listsTable) {
            $sm = $this->getServiceLocator();
            $this->listsTable = $sm->get('Recipe\Model\ListsTable');
        }
        return $this->listsTable;
    }

    //CVL ins
    public function getListDetailTable() {
        if (!$this->listDetailTable) {
            $sm = $this->getServiceLocator();
            $this->listDetailTable = $sm->get('Recipe\Model\ListDetailTable');
        }
        return $this->listDetailTable;
    }

    public function indexAction() {
        $recipeEntities = $this->getRecipeTable()->fetchAll();
        //containers
        $recipes = array();
        $difficulties = array();
        foreach ($recipeEntities as $recipe) {
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

        $form->get('submit')->setValue('Create Recipe!');

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
            } else {
                echo "recipe is not valid!";
                $recipe->exchangeArray($form->getData());
                $recipe->difficultyID = $recipe->difficultyID['difficultyID'];
                $this->printRecipe($recipe);
            }
        } else {
            //echo "recipe is not valid!";
        }

        return array('form' => $form);
    }

    public function createNewIngredientAction() {
        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Recipe\Form\CreateIngredientForm');

        //$form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $ingredient = new Ingredient();
            $form->setInputFilter($ingredient->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $ingredient->exchangeArray($form->getData());
                $this->getIngredientTable()->saveIngredient($ingredient);
                return $this->redirect()->toRoute('recipe', array('action' => 'createRecipe'));
            }
        } else {
            //echo "recipe is not valid!";
        }

        return array('form' => $form);
    }

    /* CV: getRecipesByName

      public function getSearchResultAction()
      {

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
      ));
      } */

    public function editAction() {

        $formManager = $this->getServiceLocator()->get('FormElementManager');
        $form = $formManager->get('Recipe\Form\CreateRecipeForm');
        $id = (int) $this->params()->fromRoute('recipeID', 0);
        if (!$id) {
            return $this->redirect()->toRoute('recipe', array(
                        'action' => 'createRecipe'
            ));
        }

        // Get the Recipe with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
        try {
            $recipe = $this->getRecipeTable()->getRecipe($id);
        } catch (\Exception $ex) {
            return $this->redirect()->toRoute('recipe', array(
                        'action' => 'index'
            ));
        }

        //$form = new CreateRecipeForm();
        $form->bind($recipe);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($recipe->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                //AJ: don't know why, but we need to set the id here explicitly
                $recipe->recipeID = $id;
                $recipe->difficultyID = $recipe->difficultyID->difficultyID;
                $this->printRecipe($recipe);
                $this->getRecipeTable()->saveRecipe($recipe);

                // Redirect to list of recipes
                return $this->redirect()->toRoute('recipe');
            } else {
                echo "not valid";
            }
        }

        return array(
            'recipeID' => $id,
            'form' => $form,
        );
    }
    
    private function printRecipe($recipe) {
        echo $recipe->recipeID;
        echo "<br>";
        echo $recipe->recipeName;
        echo "<br>";
        echo $recipe->description;
        echo "<br>";
        echo $recipe->instructions;
        echo "<br>";
        echo $recipe->duration;
        echo "<br>";
        echo $recipe->difficultyID;
        echo "<br>";
        echo $recipe->createUserID;
        echo "<br>";
    }

    public function deleteAction() {
        
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
        foreach ($ingredientsOfRecipe as $ingredient) {
            $ingredients[$ingredient->ingredientID] = $ingredient;
            $ingredientID = $ingredient->ingredientID;
            $ingredientNames[$ingredientID] = $this->getIngredientTable()->getIngredientName($ingredientID);
            if (!isset($ingredientWeightUnits[$ingredient->weightUnitID])) {
                $ingredientWeightUnits[$ingredient->weightUnitID] = $this->getWeightUnitsTable()->getWeightUnitName($ingredient->weightUnitID);
            }
        }
        //give data to view
        return new ViewModel(array('recipe' => $this->getRecipeTable()->getRecipe($recipeID),
            'difficulty' => $difficulty,
            'ingredientsOfRecipe' => $ingredients, 'ingredientNames' => $ingredientNames,
            'weightUnits' => $ingredientWeightUnits));
    }

    //ins CVL 
    /**
     * A list is added to default list of user
     * If a user does not yet have a list, one will be created
     * Assumption: only 1 list for each user
     */
    //asumption that user is logged in, ok because feature only available when logged-in
    //TODO if recipe already in favorite list
    //TODO view recipe
    //TODO ! get back to ?? start page
    public function addToListAction() {
        //get id of recipe which should be added to list
        $recipeID = (int) $this->params()->fromRoute('recipeID');

        //get default list of user
        if ($_SESSION['user'] != "") {
            $userID = $_SESSION['user']; //assumption user is the userid  

            $list = $this->getListsTable()->getListsByUser($userID);    //1 list                

            $listID = 0; //CVL3
            //CVL2  
            if ($list != null) { //create default list, ins CVL3
                $listID = $list->listID;
            } else { //create default list
                $listNew = new Lists();
                //use default text for name and description of list
                $listName = "favoriteList";
                $listDescription = "Default list for user";
                $listNew->exchangeArray(array('createUserID' => $userID,
                    'listName' => $listName,
                    'listDescription' => $listDescription));

                //returns id of new list
                $listID = $this->getListsTable()->saveList($listNew);
            }

            if ($listID > 0) { //CVL3                    
                //the user has now a list                                        
                $listDetailNew = new ListDetail();
                $listDetailNew->exchangeArray(array('listID' => $listID,
                    'recipeID' => $recipeID)); //CVL3                   
                //CVL3 - check if recipe is already in list is done in this function
                $this->getListDetailTable()->saveListDetail($listDetailNew);

                //CVL no validation, no info if actually inserted
                //echo "<script>alert('Recipe added to favorite list!');</script>";
            } else {
                //should not happen
                throw new \Exception("Favorite Recipe - no list found for $userID");
            }

            return $this->redirect()->toRoute('list', array('action' => 'viewList')); //CVL3 working with new entry?
            //return $this->redirect()->toRoute('recipe', array('action' => 'index')); //CVL3
        }//check if user is logged-in
    }

//method end

    /**
     * CVL3 ins
     * view the recipes of a list
     * only for logged-in user, feature on view is only provided for logged-in user
     */
    public function viewlistAction() {
        //CVL3 TODO same code as above
        //get default list of user
        if ($_SESSION['user'] != "") {
            $userID = $_SESSION['user']; //assumption user is the userid  

            $list = $this->getListsTable()->getListsByUser($userID);    //1 list                
            $listID = 0; //CVL3            

            if ($list != null) { //create default list ins CVL3 
                $listID = $list->listID;
            } else {//create default list
                $listNew = new Lists();
                //use default text for name and description of list
                $listName = "favoriteList";
                $listDescription = "Default list for user";
                $listNew->exchangeArray(array('createUserID' => $userID,
                    'listName' => $listName,
                    'listDescription' => $listDescription));


                //returns id of new list
                $listID = $this->getListsTable()->saveList($listNew);
                $list = $this->getListsTable()->getListsByUser($userID); //data of list necessary
            }

            if ($list != null) {

                //the user has now a list 
                //getListDetails
                $listDetailEntities = $this->getListDetailTable()->getListDetailForList($list->listID);
                //containers
                $listDetails = array();
                $recipes = array();
                $difficulties = array();

                //get recipeData for included recipes
                foreach ($listDetailEntities as $listDetail) {
                    $listDetails[$listDetail->listID] = $listDetail;
                    $recipes[$listDetail->recipeID] = $this->getRecipeTable()->getRecipe($listDetail->recipeID);
                }


                foreach ($recipes as $recipe) {
                    $recipes[$recipe->recipeID] = $recipe;
                    $difficulties[$recipe->recipeID] = $this->getDifficultiesTable()->getDifficultyName($recipe->difficultyID);
                }
            }

            return new ViewModel(array(
                'list' => $list, 'recipes' => $recipes,
                'difficulties' => $difficulties,
            ));
        } //check loggin / session
    }

}
