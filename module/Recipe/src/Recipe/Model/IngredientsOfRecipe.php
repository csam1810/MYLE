<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IngredientsOfRecipe
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */
namespace Recipe\Model;

class IngredientsOfRecipe {
    
    public $amount;
    public $weightUnitID;
    public $ingredientID;
    public $recipeID;
    
    protected $inputFilter;
    
    //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {
         $this->amount    = (!empty($data['amount'])) ? $data['amount'] : null;
         $this->weightUnitID = (!empty($data['weightUnitID'])) ? $data['weightUnitID'] : null;
         $this->ingredientID = (!empty($data['ingredientID'])) ? $data['ingredientID'] : null;
         $this->recipeID = (!empty($data['recipeID'])) ? $data['recipeID'] : null;
     }
}
