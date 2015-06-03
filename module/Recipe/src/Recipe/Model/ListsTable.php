<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * CVL ins
 * Description of ListsTable 
 */

namespace Recipe\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;  //cvl ok?like in recipe, not in difficulty
 
class ListsTable extends AbstractTableGateway{
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

     /**
      * Returns either the list of the user or null
      */
     //CVL assumption there is exactly 1 list (already created, not more)  
     public function getListsByUser($userID)
     {   
         
         $rowset = $this->tableGateway->select(array('createUserID' => $userID));
         //CVL 2 if ($rowset->count() > 0){
         
         $row = null;
         $row = $rowset->current();
         
         if (!$row) {
             //CVL TODO create List - right now on 2 places in controller, list properties necessary
             //throw new \Exception("ListsTable: Could not find list for $userID");
             
         }
         
         return $row;
         //CVL 2 }
     }
     
     /*getList returns either list with requested ID or null*/
     public function getList($listID)
     {
         $listID  = (int) $listID;
         $rowset = $this->tableGateway->select(array('listID' => $listID));
         $row = null;
         $row = $rowset->current();
         if (!$row) {         
         //    throw new \Exception("Could not find list (row) with id $listID");
         }
         return $row;
     }
     
     //CVL2 ins
     /**
      * List will be created in DB
      * ListID is automatically set by DB
      * @return listID of newly created list
      */
   
     public function saveList(Lists $list)
     {
         $data = array(
             'createUserID'     => $list->createUserID,
             'listName'         => $list->listName,
             'listDescription'  => $list->listDescription,             
         );

         //autoincrement, same as recipeid
         $id = (int) $list->listID;
         
         if ($id <= 0) {
             $this->tableGateway->insert($data);
             //set ID of newly inserted entity
             $id = $this->tableGateway->lastInsertValue;
         } else {
             /*if ($this->getList($id)) {
                 $this->tableGateway->update($data, array('listID' => $listID));
             } else {
                 throw new \Exception('List id does not exist');
             }*/
         }
         return $id;
     }
     
     //CVL db should delete listdetails automatically, CV2 changed deleteID, not tested
      public function deleteList($listID)
     {
         $this->tableGateway->delete(array('$deleteID' => (int) $listID));
     }
}