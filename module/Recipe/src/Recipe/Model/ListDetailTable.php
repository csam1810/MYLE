<?php

/**
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

     /**
      get all data for list details
      */
     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select();
         return $resultSet;
     }
     
     
    
     /**
      * get all listDetail for a specific list
      */
     public function getListDetailForList($listID)
     {
         $listIDTemp  = (int) $listID;
         $rowset = $this->tableGateway->select(array('listID' => $listIDTemp));
         return $rowset;         
     }
     
     /**
      get a specific listDetail defined by listID and recipeID
      * return null if not found  
      */
      public function getListDetail($listID, $recipeID)
     {  
         $listID  = (int) $listID;
         $recipeID  = (int) $recipeID;
         $rowset = $this->tableGateway->select(array('listID' => $listID, 'recipeID' => $recipeID));
         $row = null;
         $row = $rowset->current();    
         return $row;
     }
     
     
     /**
      * add a listDetail to a list
      * listid and recipeID are included in parameter listDetail
      * check if recipe is already in list is done
      */
     public function saveListDetail(ListDetail $listDetail)
     {         
         $data = array(
             'listID' => (int) $listDetail->listID,             
             'recipeID' => (int) $listDetail->recipeID
         );
         
         //check if already in database, meaning recipe already added to list                  
         if ($this->getListDetail($listDetail->listID, $listDetail->recipeID) == null) {
            $this->tableGateway->insert($data);                  
         } else {                             
             //nothing happens when already, list content is shown anyway            
         }         
     }
     
     
     /*
      * Delete a recipe from a list     
      * no error if not in db
      */
     public function removeRecipeFromList($listID, $recipeID)
     {        
           $data = array(
             'listID' => (int) $listID,             
             'recipeID' => (int) $recipeID
              );
                   
         if ($this->getListDetail($listID, $recipeID) == null) {
             //should not happen, but no problem either
             //throw new \Exception("Recipe is not in list with listID $listID recipeID $recipeID");             
         } else {                        
                $this->tableGateway->delete($data);                             
         }
     }
 }
