<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeightUnit
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */

namespace Recipe\Model;

class WeightUnits {
    
    public $unitID;
    public $unitName;
    
    public function exchangeArray($data) {
         $this->unitID  = (!empty($data['unitID'])) ? $data['unitID'] : null;
         $this->unitName    = (!empty($data['unitName'])) ? $data['unitName'] : null;       
    }
}
