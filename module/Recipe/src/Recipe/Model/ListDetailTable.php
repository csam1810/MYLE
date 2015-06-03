<?php

/**
 * ins CVL
 * Description of ListDetailTable
 *
 */
namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;

 class ListDetailTable
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
     
     //CVL not yet used
     public function getListDetailForRecipe($recipeID)
     {
         $recipeID  = (int) $recipeID;
         $rowset = $this->tableGateway->select(array('recipeID' => $recipeID));
         return $rowset;         
     }
     
     
    
     public function getListDetailForList($listID)
     {
         $listID  = (int) $listID;
         $rowset = $this->tableGateway->select(array('listID' => $listID));
         return $rowset;         
     }
     
     //ins CVL3
      public function getListDetail($listID, $recipeID)
     {
         $listID  = (int) $listID;
         $recipeID  = (int) $recipeID;
         $row = null;
         $rows = $this->tableGateway->select(array('listID' => $listID, 'recipeID' => $recipeID));
         return $row;         
     }
     
     //CVL
     public function saveListDetail(ListDetail $listDetail)
     {
         $data = array(
             'listID' => $listDetail->listID,             
             'recipeID' => $listDetail->recipeID,
         );

         //CVL3
         //check if already in database, meaning recipe already added to list
         $listDetailinDB = $this->getListDetail($listDetail->listID, $listDetail->recipeID);
         if ($listDetailinDB == null){
         $this->tableGateway->insert($data);
         }
         //CVL TODO return data necessary? id would be the combination of listid and recipeid  
         //no information for caller if data were inserted or already in DB 
     }
 }
