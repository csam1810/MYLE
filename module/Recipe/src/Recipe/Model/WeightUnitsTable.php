<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeightUnitsTable
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */

namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;
 
class WeightUnitsTable {
    
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

     public function getWeightUnitName($unitID)
     {
         $rowset = $this->tableGateway->select(array('unitID' => $unitID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $unitID");
         }
         return $row->unitName;
     }
}
