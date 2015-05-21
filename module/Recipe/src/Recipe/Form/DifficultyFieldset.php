<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DifficultySelect
 *
 * @author Alexandra Jäger <alexandra.jaeger@student.uibk.ac.at>
 */
namespace Recipe\Form;

use Recipe\Model\DifficultiesTable;
use Zend\Form\Fieldset;

class DifficultyFieldset extends Fieldset {
    
    public function __construct(DifficultiesTable $difficultiesTable)
    {
        parent::__construct('difficultyID');
        
        $difficulties = $difficultiesTable->fetchAll();
        $difficultyArray = array();
        foreach($difficulties as $difficulty) {
            $difficultyArray[$difficulty->difficultyID] = $difficulty->difficultyName;
        }
        
        var_dump($difficultyArray);
        
        $this->add(array(
             'name' => 'difficultyID',
             'type' => 'Zend\Form\Element\Select',
             'options' => array(
                 'label' => 'Difficulty',
                 'value_options' => array($difficultyArray),
             ),
         ));
    }
}
