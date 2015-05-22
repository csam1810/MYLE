<?php

/**
 * Description of IngredientsOfRecipeTable
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */
namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;

 class IngredientsOfRecipeTable
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
     
     public function getIngredientsForRecipe($recipeID)
     {
         $recipeID  = (int) $recipeID;
         $rowset = $this->tableGateway->select(array('recipeID' => $recipeID));
         return $rowset;         
     }
     
     public function saveIngredientsOfRecipe(IngredientsOfRecipe $ingredients)
     {
         $data = array(
             'amount' => $ingredients->amount,
             'weightUnitID'  => $ingredients->weightUnitID,
             'recipeID' => $ingredients->recipeID,
             'ingredientID' => $ingredients->ingredientID,
         );

         //TODO: for now just insert without checking of element exists
         $this->tableGateway->insert($data);
         //set ID of newly inserted entity
         $id = $this->tableGateway->lastInsertValue;
         return $id;
     }
 }
