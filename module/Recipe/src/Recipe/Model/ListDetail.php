<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/** 
 * Description of ListDetail
 
 */
namespace Recipe\Model;

class ListDetail {
        
    public $listID;
    public $recipeID;
        
    //this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {         
         $this->listID = (!empty($data['listID'])) ? $data['listID'] : null;
         $this->recipeID = (!empty($data['recipeID'])) ? $data['recipeID'] : null;
     }
}
