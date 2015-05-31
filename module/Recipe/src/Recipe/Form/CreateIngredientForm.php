<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateIngredientForm
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */
namespace Recipe\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class CreateIngredientForm extends Form {
   
    public function __construct($name = null, $options = array())
     {
         parent::__construct($name, $options);
         
         $this->setHydrator(new ClassMethodsHydrator());
     }
    
     public function init() {
         $this->add(array(
             'name' => 'id',
             'type' => 'Hidden',
         ));
         
         $this->add(array(
             'name' => 'createUserID',
             'type' => 'Hidden',
             'attributes' => array(
                 'value' => $_SESSION['user']
              ),
         ));

         $this->add(array(
             'name' => 'ingredientName',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Name of ingredient',
             ),
             'attributes' => array(
                 'class' => 'form-control',
             )
         )); 
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Create Ingredient!',
                 'id' => 'submitbutton',
             ),
         ));
    }
}
