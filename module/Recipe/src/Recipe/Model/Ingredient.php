<?php

/**
 * Description of Ingredient
 *
 * @author alexandra
 */

namespace Recipe\Model;

class Ingredient {
    public $ingredientID;
    public $ingredientName;
    
    //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {
         $this->ingredientID  = (!empty($data['ingredientID'])) ? $data['ingredientID'] : null;
         $this->ingredientName    = (!empty($data['ingredientName'])) ? $data['ingredientName'] : null;
     }
}
