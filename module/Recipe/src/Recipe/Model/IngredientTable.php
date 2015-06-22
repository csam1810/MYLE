<?php

/**
 * Description of IngredientTable
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */
namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;

 class IngredientTable
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

     public function getIngredientName($ingredientID)
     {
         $ingredientID  = (int) $ingredientID;
         $rowset = $this->tableGateway->select(array('ingredientID' => $ingredientID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $ingredientID");
         }
         return $row->ingredientName;
     }
     
     //used to check if ingredient already exists
     public function doesIngredientExist($ingredientName)
     {
         $rowset = $this->tableGateway->select(array('ingredientName' => $ingredientName));
         $row = $rowset->current();
         if (!$row) {
             return false;
         } else {
             return true;
         }
     }

     public function saveIngredient(Ingredient $ingredient)
     {
         $data = array(
             'ingredientName' => $ingredient->ingredientName,
             'createUserID' => $ingredient->createUserID,
         );

         $id = (int) $ingredient->ingredientID;
         if ($id == 0) {
             if($this->doesIngredientExist($ingredient->ingredientName)) {
                 return false;
             } else {
                $this->tableGateway->insert($data);
                return true;
             }
         } else {
             if ($this->getIngredient($id)) {
                 $this->tableGateway->update($data, array('ingredientID' => $ingredientID));
             } else {
                 throw new \Exception('Ingredient id does not exist');
             }
         }
     }

     public function deleteIngredient($ingredientID)
     {
         $this->tableGateway->delete(array('$ingredientID' => (int) $ingredientID));
     }
 }
