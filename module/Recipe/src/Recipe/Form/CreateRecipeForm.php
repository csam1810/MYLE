<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CreateRecipeForm
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */

namespace Recipe\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;


class CreateRecipeForm extends Form {
    
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
             'name' => 'recipeName',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Recipe Name',
             ),
             'attributes' => array(
                 'class' => 'form-control',
             )
         ));
         $this->add(array(
             'name' => 'instructions',
             'type' => 'Textarea',
             'options' => array(
                 'label' => 'Instructions',
             ),
             'attributes' => array(
                 'class' => 'form-control',
                 'rows' => '10',
                 'cols' => '100',
             ),
         ));
         
         $this->add(array(
             'type' => 'Zend\Form\Element\Collection',
             'name' => 'ingredients',
             'options' => array(
                 'label' => 'Please choose ingredients for this recipe',
                 'count' => 3,
                 'should_create_template' => true,
                 'template_placeholder' => '__ingredientGroup__',
                 'allow_add' => true,
                 'target_element' => array(
                     'type' => 'IngredientFieldset',
                 ),
                 
             ),
             'attributes' => array(
                 'class' => 'form-horizontal',
                 'id' => 'ingredientGroupFieldset',
                ),
         ));
         
         $this->add(array(
             'name' => 'duration',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Duration',
             ),
             'attributes' => array(
                 'class' => 'form-control',
             )
         ));
         
         $this->add(array(
             'name' => 'difficultyID',
             'type' => 'DifficultyFieldset',
         ));
         
         $this->add(array(
             'name' => 'submit',
             'type' => 'Submit',
             'attributes' => array(
                 'value' => 'Create Recipe!',
                 'id' => 'submitbutton',
                 
             ),
         ));
    }
}
