<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
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
                'label' => 'Recipe name contains',                
            ),
            'attributes' => array(
                'class' => 'form-control',                
                'size' => 31,
            )
        ));              
         
       $this->add(array(
            'name' => 'duration',
            'type' => 'Text',
            'options' => array(
                'label' => 'Duration smaller or equal than (in minutes)',
            ),
            'attributes' => array(
                'class' => 'form-control',                
            )
        ));
  
         $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Show',
                'id' => 'submitbutton',
            ),
        ));
   
    }

}
