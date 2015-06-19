<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Createaccount\Model;

 use Zend\Db\TableGateway\TableGateway;

 class CreateaccountTable
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

     public function getUser($id)
     {
         $rowset = $this->tableGateway->select(array('userID' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveCreateAccount(Createaccount $user)
     {
         $data = array(
             'userID' => $user->id,
             'displayName'  => $user->displayName,
             'phoneNo' => $user->phoneNo,
             'password'  => $user->password,
         );

         $id = $user->id;
         $userRowData = $this->getUser($id);
         
         if($userRowData !=null){
              echo "User id does exist";
              return $this->redirect()->toRoute('createaccount', array('action' => 'add'));
         }
         else{
              $this->tableGateway->insert($data);
              return $this->redirect()->toRoute('recipe', array('action' => 'index'));
         }
        
     }
    
 }