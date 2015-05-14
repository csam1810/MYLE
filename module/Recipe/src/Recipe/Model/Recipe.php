<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 class Recipe
 {
     public $recipeID;
     public $recipeName;
     public $instructions;
     public $duration;
     public $difficultyID;

     //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {
         $this->recipeID  = (!empty($data['recipeID'])) ? $data['recipeID'] : null;
         $this->recipeName    = (!empty($data['recipeName'])) ? $data['recipeName'] : null;
         $this->instructions = (!empty($data['instructions'])) ? $data['instructions'] : null;
         $this->duration = (!empty($data['duration'])) ? $data['duration'] : null;
         $this->difficultyID = (!empty($data['difficultyID'])) ? $data['difficultyID'] : null;
     }
 }