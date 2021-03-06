<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WeightUnitFieldset
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */

namespace Recipe\Form;

use Recipe\Model\WeightUnitsTable;
use Zend\Form\Fieldset;
use Recipe\Model\WeightUnits;

use Zend\Stdlib\Hydrator\ClassMethods as ClassMethodsHydrator;

class WeightUnitFieldset extends Fieldset{
    
    public function __construct(WeightUnitsTable $weightUnitsTable)
    {
        parent::__construct('unitName');
        
        $this->setHydrator(new ClassMethodsHydrator(false));
        $this->setObject(new WeightUnits());
        
        $weightUnits = $weightUnitsTable->fetchAll();
        
        $weightUnitsArray = array();
        foreach($weightUnits as $weightUnit) {
            $weightUnitsArray[$weightUnit->unitID] = $weightUnit->unitName;
        }
        
        $this->add(array(
             'name' => 'unitName',
             'type' => 'Zend\Form\Element\Select',
             'options' => array(
                 'label' => 'Weight Unit: ',
                 'value_options' => $weightUnitsArray,
             ),
            'attributes' => array(
                 'class' => 'form-horizontal',
             ),
         ));
    }
}
