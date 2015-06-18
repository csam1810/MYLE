<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Lists 
 */
 

namespace Recipe\Model; 

class Lists{
    
    public $listID;
    public $createUserID;
    public $listName;  
    public $listDescription;
    
    
    public function exchangeArray($data) {
        $this->listID           = (!empty($data['listID'])) ? $data['listID'] : null;
        $this->createUserID     = (!empty($data['createUserID'])) ? $data['createUserID'] : null;
        $this->listName         = (!empty($data['listName'])) ? $data['listName'] : null;              
        $this->listDescription  = (!empty($data['listDescription'])) ? $data['listDescription'] : null;
    }
}
