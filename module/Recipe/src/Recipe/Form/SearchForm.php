<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**CVL5
 * Description of Search Form
 * 
 */

namespace Recipe\Form;

use Zend\Form\Form;
use Zend\Stdlib\Hydrator\ArraySerializable;

class SearchForm extends Form {

    public function __construct($name = null, $options = array()) {
        parent::__construct($name, $options);

        $this->setHydrator(new ArraySerializable());        

        $this->add(array(
            'name' => 'searchTerm',
            'type' => 'Text',
            'options' => array(
                'label' => 'searchTerm',
            ),
            'attributes' => array(
                'class' => 'form-control',
            )
        ));              
        
         $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'SearchRecipe',
                'id' => 'submitbutton',
            ),
        ));
   
    }

    
    /*public function init() {
        /*$this->add(array(
            'type' => 'Zend\Form\Element\Collection',
            'name' => 'ingredients',
            'options' => array(
                'label' => 'Please choose ingredients for this recipe',
                'count' => 1,
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
        
    }*/

}
