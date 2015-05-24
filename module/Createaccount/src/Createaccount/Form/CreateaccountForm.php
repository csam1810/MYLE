<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 namespace Createaccount\Form;
 use Zend\Form\Form;

 class CreateaccountForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('createaccount');

         $this->add(array(
             'name' => 'createAccountid',
             'type' => 'Text',
         ));
         $this->add(array(
             'name' => 'displayName',
             'type' => 'Text',
         ));
         $this->add(array(
             'name' => 'phoneNo',
             'type' => 'Text',
         ));
         $this->add(array(
             'name' => 'createAccountpassword',
             'type' => 'Password',
         ));
         $this->add(array(
             'name' => 'repassword',
             'type' => 'Password',
         ));
         $this->add(array(
             'name' => 'createAccountsubmit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitCreateButton',
             ),
         ));
     }
 }