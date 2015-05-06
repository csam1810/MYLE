<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;

 class RecipeTable
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

     public function getRecipe($id)
     {
         $id  = (int) $id;
         $rowset = $this->tableGateway->select(array('id' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveRecipe(Recipe $recipe)
     {
         $data = array(
             'instructions' => $recipe->instructions,
             'title'  => $recipe->title,
         );

         $id = (int) $recipe->id;
         if ($id == 0) {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getRecipe($id)) {
                 $this->tableGateway->update($data, array('id' => $id));
             } else {
                 throw new \Exception('Recipe id does not exist');
             }
         }
     }

     public function deleteRecipe($id)
     {
         $this->tableGateway->delete(array('id' => (int) $id));
     }
 }