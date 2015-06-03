<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DifficultiesTable
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */

namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;
 
class DifficultiesTable {
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

     public function getDifficultyName($difficultyID)
     {
         $rowset = $this->tableGateway->select(array('difficultyID' => $difficultyID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find name for difficulty name for key $difficultyID (DifficultiesTable)"); //CVL3
             //throw new \Exception("Could not find row $difficultyID"); //CVL3
         }
         return $row->difficultyName;
     }
}
