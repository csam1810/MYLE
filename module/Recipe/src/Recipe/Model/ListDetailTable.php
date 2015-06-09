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
         $recipeIDTemp  = (int) $recipeID; //CVL4 upd added Temp
         $rowset = $this->tableGateway->select(array('recipeID' => $recipeIDTemp)); //CVL4 upd added Temp
         return $rowset;         
     }
     
     
    
     public function getListDetailForList($listID)
     {
         $listIDTemp  = (int) $listID; //CVL4 upd added Temp
         $rowset = $this->tableGateway->select(array('listID' => $listIDTemp)); //CVL4 upd added Temp
         return $rowset;         
     }
     
     //CVL 4
      public function getListDetail($listID, $recipeID)
     {  
         $listID  = (int) $listID;
         $recipeID  = (int) $recipeID;
         $rowset = $this->tableGateway->select(array('listID' => $listID, 'recipeID' => $recipeID));
         $row = null; //CVL4
         $row = $rowset->current();    
         return $row;
     }
     
     
     //CVL
     public function saveListDetail(ListDetail $listDetail)
     {
         //CVL4 upd added int, remove , after recipeID
         $data = array(
             'listID' => (int) $listDetail->listID,             
             'recipeID' => (int) $listDetail->recipeID
         );

         //CVL3
         //check if already in database, meaning recipe already added to list
                  
         if ($this->getListDetail($listDetail->listID, $listDetail->recipeID) == null) {
            $this->tableGateway->insert($data);                  
         } else {                             
             //nothing happens when already, list content is shown anyway
            //throw new \Exception("Recipe already in list $listDetail->listID, $listDetail->recipeID");                
         }
         //CVL TODO return data necessary? id would be the combination of listid and recipeid  
         //now no information for caller if data were inserted or already in DB 
     }
     
     
     //CVL4 Delete a recipe from a list     
     //check if in db
     public function removeRecipeFromList($listID, $recipeID)
     {        
           $data = array(
             'listID' => (int) $listID,             
             'recipeID' => (int) $recipeID
              );
                   
         if ($this->getListDetail($listID, $recipeID) == null) {
             //should not happen
             throw new \Exception("Recipe is not in list with listID $listID recipeID $recipeID");             
         } else {                        
                $this->tableGateway->delete($data);                             
         }
     }
 }//class
