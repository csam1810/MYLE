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

class CreateRecipeForm extends Form {
    
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
         ));
         $this->add(array(
             'name' => 'instructions',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Instructions',
             ),
         ));
         
         echo "TODO: ingredients!";
         
         $this->add(array(
             'name' => 'duration',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Duration',
             ),
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
