<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\TableGateway\AbstractTableGateway;

 class RecipeTable extends AbstractTableGateway
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }

     public function getRecipe($recipeID)
     {
         $recipeID  = (int) $recipeID;
         $rowset = $this->tableGateway->select(array('recipeID' => $recipeID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $recipeID");
         }
         return $row;
     }
     
     /*CV: get recipes by name for searching
      * result can be >=0
        extend ability to search 
        "SELECT * FROM student WHERE name LIKE '%John%'";    
        
      * is cast necessary for string?
      *       */
     
     
      public function getRecipeByName($searchTerm)
     {
         $recipeName  = (string) $searchTerm;
         $rowset = $this->tableGateway->select(array('recipeName' => $recipeName));                  
         return $resultSet;         
     }

     public function saveRecipe(Recipe $recipe)
     {
         $data = array(
             'instructions' => $recipe->instructions,
             'recipeName'  => $recipe->recipeName,
             'duration' => $recipe->duration,
             'difficultyID' => $recipe->difficultyID,
             'createUserID' => $recipe->createUserID,
         );

         $id = (int) $recipe->recipeID;
         if ($id == 0) {
             $this->tableGateway->insert($data);
             //set ID of newly inserted entity
             $id = $this->tableGateway->lastInsertValue;
         } else {
             if ($this->getRecipe($id)) {
                 $this->tableGateway->update($data, array('recipeID' => $recipeID));
             } else {
                 throw new \Exception('Recipe id does not exist');
             }
         }
         return $id;
     }

     public function deleteRecipe($recipeID)
     {
         $this->tableGateway->delete(array('$recipeID' => (int) $recipeID));
     }
 }