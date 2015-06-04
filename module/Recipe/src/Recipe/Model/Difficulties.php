<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Difficulties
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */

namespace Recipe\Model;

class Difficulties {
    
    public $difficultyID;
    public $difficultyName;
    
    public function exchangeArray($data) {
        $this->difficultyID  = (!empty($data['difficultyID'])) ? $data['difficultyID'] : null;
        $this->difficultyName    = (!empty($data['difficultyName'])) ? $data['difficultyName'] : null;
    }
    
    public function getArrayCopy()
     {
         return get_object_vars($this);
     }
}
