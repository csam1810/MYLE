<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** 
 * Description of ListsTable 
 */

namespace Recipe\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\AbstractTableGateway;
 
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
     //assumption there is exactly 1 list (already created, not more)  
     public function getListsByUser($userID)
     {   
         
         $rowset = $this->tableGateway->select(array('createUserID' => $userID));
         
         $row = null;
         $row = $rowset->current();
                  
         return $row;         
     }
     
     /**
      * get the list for given listID or give back null
      */
     public function getList($listID)
     {
         $listID  = (int) $listID;
         $rowset = $this->tableGateway->select(array('listID' => $listID));
         $row = null;
         $row = $rowset->current();         
         return $row;
     }
     
     /**
      * Create list in DB
      * ListID is automatically set by DB
      * listID of newly created list is returned
      */
   
     public function saveList(Lists $list)
     {
         $data = array(
             'createUserID'     => $list->createUserID,
             'listName'         => $list->listName,
             'listDescription'  => $list->listDescription,             
         );

         //autoincrement
         $id = (int) $list->listID;
         
         if ($id <= 0) {
             $this->tableGateway->insert($data);
             //set ID of newly inserted entity
             $id = $this->tableGateway->lastInsertValue;
         }            
         return $id;
     }    
}