<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 class Recipe
 {
     public $id;
     public $title;
     public $instructions;

     //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {
         $this->id     = (!empty($data['id'])) ? $data['id'] : null;
         $this->instructions = (!empty($data['instructions'])) ? $data['instructions'] : null;
         $this->title  = (!empty($data['title'])) ? $data['title'] : null;
     }
 }