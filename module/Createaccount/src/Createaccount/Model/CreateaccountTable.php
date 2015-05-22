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

     public function getCreateAccount($id)
     {
       //  $id  = (string) $id;
         $rowset = $this->tableGateway->select(array('ID' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveCreateAccount(Createaccount $createAccount)
     {
         $data = array(
             'ID' => $createAccount->id,
             'DisplayName'  => $createAccount->displayName,
             'PhoneNo' => $createAccount->phoneNo,
             'Password'  => $createAccount->password,
         );

         $id = $createAccount->id;
    /*     if ($id == '') {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getCreateAccount($id)) {
                 $this->tableGateway->update($data, array('ID' => $id));
             } else {
                 throw new \Exception('User id does not exist');
             }
         }
      */
         $userRowData = getCreateAccount($id);
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