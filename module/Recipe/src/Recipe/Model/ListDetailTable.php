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
     
     //CVL OR should it be addRecipeToList?
     public function saveListDetail(ListDetail $listDetail)
     {
         $data = array(
             'listID' => $listDetail->listID,             
             'recipeID' => $listDetail->recipeID,
         );

         //CVL TODO: for now just insert without checking of they exists, cause db error if not
         $this->tableGateway->insert($data);
         //CVL TODO return data? no own id, combination of listid and recipeid         
     }
 }
