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

     //CVL assumption there is exactly 1 list (already created, not more)
     //only listid back not list
     public function getListsByUser($userID)
     {
         $rowset = $this->tableGateway->select(array('createUserID' => $userID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find list for $userID");
         }
         return $row->listID;
     }
     
     public function getList($listID)
     {
         $listID  = (int) $listID;
         $rowset = $this->tableGateway->select(array('listID' => $listID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find list (row) with id $listID");
         }
         return $row;
     }
     
     public function saveList(Lists $list)
     {
         $data = array(
             'createUserID' => $list->createUserID,
             'listName'  => $list->listName,
             'listDescription' => $list->listDescription,             
         );

         //autoincrement, same as recipeid
         $id = (int) $list->listID;
         
         if ($id == 0) {
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
     
     //CVL db should delete listdetails automatically
      public function deleteList($listID)
     {
         $this->tableGateway->delete(array('$deleteID' => (int) $deleteID));
     }
}