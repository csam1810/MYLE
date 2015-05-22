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

class IngredientFieldset extends Fieldset{
    
    public function __construct()
    {
         parent::__construct('ingredients');
         
         $this->setHydrator(new ClassMethodsHydrator(false));
         $this->setObject(new IngredientsOfRecipe());

    }
    
    public function init() {
        $this->add(array(
             'name' => 'ingredientName',
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
}
