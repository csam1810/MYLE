<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of IngredientFieldset
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */
namespace Recipe\Form;

use Recipe\Model\IngredientTable;
use Zend\Form\Fieldset;

class IngredientFieldset extends Fieldset {
    
    public function __construct(IngredientTable $ingredientTable)
    {
        parent::__construct('ingredients');
        
        $ingredients = $ingredientTable->fetchAll();
        
        $ingredientsArray = array();
        foreach($ingredients as $ingredient) {
            $ingredientsArray[$ingredient->ingredientID] = $ingredient->ingredientName;
        }
        
        $this->add(array(
             'name' => 'ingredients',
             'type' => 'Zend\Form\Element\Select',
             'options' => array(
                 'label' => 'Ingredient',
                 'value_options' => $ingredientsArray,
             ),
            'attributes' => array(
                 'class' => 'form-control',
             ),
         ));
    }
}
