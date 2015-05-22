<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login\Model;

 use Zend\Db\TableGateway\TableGateway;

 class LoginTable
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

     public function getLogin($id)
     {
       //  $id  = (string) $id;
         $rowset = $this->tableGateway->select(array('loginid' => $id));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $id");
         }
         return $row;
     }

     public function saveLogin(Login $login)
     {
         $data = array(
             'instructions' => $login->instructions,
             'title'  => $login->title,
         );

         $id = $login->id;
         if ($id == '') {
             $this->tableGateway->insert($data);
         } else {
             if ($this->getLogin($id)) {
                 $this->tableGateway->update($data, array('loginid' => $id));
             } else {
                 throw new \Exception('User id does not exist');
             }
         }
     }

 }