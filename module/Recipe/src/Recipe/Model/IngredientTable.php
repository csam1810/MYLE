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

     public function saveIngredient(Ingredient $ingredient)
     {
         $data = array(
             'ingredientName' => $ingredient->ingredientName,
         );

         $id = (int) $ingredient->ingredientID;
         if ($id == 0) {
             $this->tableGateway->insert($data);
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
