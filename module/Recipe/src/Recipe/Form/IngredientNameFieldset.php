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
use Recipe\Model\Ingredient;
use Zend\InputFilter\InputFilterProviderInterface;

use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class IngredientNameFieldset extends Fieldset implements InputFilterProviderInterface {
    
    public function __construct(IngredientTable $ingredientTable)
    {
        parent::__construct('ingredientName');
        
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new Ingredient());
        
        $ingredients = $ingredientTable->fetchAll();
        
        $ingredientsArray = array();
        $ingredientsArray[0] = "";
        foreach($ingredients as $ingredient) {
            $ingredientsArray[$ingredient->ingredientID] = $ingredient->ingredientName;
        }
        
        $this->add(array(
             'name' => 'ingredientID',
             'type' => 'Zend\Form\Element\Select',
             'options' => array(
                 'label' => 'Ingredient: ',
                 'value_options' => $ingredientsArray,
             ),
            'attributes' => array(
                 'class' => 'form-horizontal',
             ),
         ));
    }

    public function getInputFilterSpecification()
     {
        return array(
             'ingredientID' => array(
                 'required' => true,
                 'filters' => array(
                    array('name' => 'Int'),
                ),
                'validators' => array(
                    array(
                        'name' => 'GreaterThan',
                        'options' => array(
                            'min' => 0,
                            'inclusive' => false,
                            'message' => 'Please choose an ingredient!',
                        )
                    ),
                ),
            ),
         );
     }
}
