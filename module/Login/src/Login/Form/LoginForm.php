<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 namespace Login\Form;
 use Zend\Form\Form;

 class LoginForm extends Form
 {
     public function __construct($name = null)
     {
         // we want to ignore the name passed
         parent::__construct('login');

         $this->add(array(
             'name' => 'loginid',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Email',
             ),
         ));
      
         $this->add(array(
             'name' => 'loginpassword',
             'type' => 'Password',
             'options' => array(
                 'label' => 'Password',
             ),
         ));
         
         $this->add(array(
             'name' => 'loginsubmit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Go',
                 'id' => 'submitLoginButton',
             ),
         ));
     }
 }