<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\TableGateway\AbstractTableGateway;
 use Zend\Db\Adapter\Driver\ResultInterface;
 use Zend\Db\ResultSet\ResultSet;           

 class RecipeTable extends AbstractTableGateway
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select(function($select) {
            $select->order('createDate DESC');
            // insert some awesome ordering magic here..!
        });
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
     
     /** 
      * get recipes which name have the searchTerm included
      * result can be more than 1 recipe
      */    
      public function getRecipeByName($searchTerm)
     {
              
         $db = getAdapter();      
         $statement = $db->createStatement("SELECT * FROM Recipe WHERE recipeName LIKE '%".$searchTerm."%'");
         $result = $statement->execute();
         $rowset = new ResultSet;
         $rowset->initialize($result);                                    
         return $rowset;         
     }
     
     
     /**
      *get recipes which have a duration smaller than or equal the given value
      */
     public function getRecipeByDuration($duration)
     {
         $db = getAdapter();         
         $statement = $db->createStatement("SELECT * FROM Recipe WHERE duration <=".$duration);
         $result = $statement->execute();
         $rowset = new ResultSet;
         $rowset->initialize($result);
               
         return $rowset;         
     }
          
     /**
      * get recipes which have a name where the searchTerm is a substring 
      * and duration of recipe is smaller than or equal the given value
      */
     public function getRecipeByNameAndDuration($searchTerm, $duration)
     {
         $db = getAdapter();         
         $statement = $db->createStatement("SELECT * FROM Recipe WHERE recipeName LIKE '%".$searchTerm."%' AND duration <=".$duration);
         $result = $statement->execute();
         $rowset = new ResultSet;
         $rowset->initialize($result);
               
         return $rowset;         
     }
     
    /**
     * Save a given recipe to database
     */
     public function saveRecipe(Recipe $recipe)
     {
         $data = array(
             'instructions' => $recipe->instructions,
             'description' => $recipe->description,
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
                 $this->tableGateway->update($data, array('recipeID' => $id));
             } else {
                 throw new \Exception('Recipe id does not exist');
             }
         }
         return $id;
     }

     /**
      * delete a recipe in database with given recipeID
      */
     public function deleteRecipe($recipeID)
     {
         $this->tableGateway->delete(array('recipeID' => (int) $recipeID));
     }
 }