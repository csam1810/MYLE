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

use Zend\Form\Fieldset;
use \Recipe\Model\IngredientsOfRecipe;
use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;
use Zend\InputFilter\InputFilterProviderInterface;

class IngredientFieldset extends Fieldset implements InputFilterProviderInterface {
    
    public function __construct()
    {
         parent::__construct('ingredients');
         
         $this->setHydrator(new ClassMethodsHydrator(false));
         $this->setObject(new IngredientsOfRecipe());

         $this->setAttribute('class','form-horizontal');
    }
    
    public function init() {
        $this->add(array(
             'name' => 'ingredientID',
             'type' => 'IngredientNameFieldset',
         ));
         
         $this->add(array(
             'name' => 'ingredientAmount',
             'type' => 'Text',
             'options' => array(
                 'label' => 'Amount: ',
             ),
             'attributes' => array(
                 'class' => 'form-horizontal',
             )
         ));
         
         $this->add(array(
             'name' => 'weightUnit',
             'type' => 'WeightUnitFieldset',
         ));
    }
    
    public function getInputFilterSpecification()
     {
        return array(
             'ingredientAmount' => array(
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
                            'message' => 'Please choose an amount > 0!',
                        )
                    ),
                ),
            ),
         );
     }
}
