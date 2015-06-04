<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 use Zend\InputFilter\InputFilter;


 class Recipe implements InputFilterAwareInterface
 {
     public $recipeID;
     public $recipeName;
     public $description;
     public $instructions;
     public $duration;
     public $difficultyID;
     public $owner;
     
     protected $inputFilter;

     //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {
         $this->recipeID  = (!empty($data['recipeID'])) ? $data['recipeID'] : null;
         $this->recipeName    = (!empty($data['recipeName'])) ? $data['recipeName'] : null;
         $this->description    = (!empty($data['description'])) ? $data['description'] : null;
         $this->instructions = (!empty($data['instructions'])) ? $data['instructions'] : null;
         $this->duration = (!empty($data['duration'])) ? $data['duration'] : null;
         $this->difficultyID = (!empty($data['difficultyID'])) ? $data['difficultyID'] : null;
         $this->createUserID  = (!empty($data['createUserID'])) ? $data['createUserID'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }


    public function getInputFilter() {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'createUserID',
                 'required' => true,
             ));

             $inputFilter->add(array(
                 'name'     => 'recipeName',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 3,
                             'max'      => 255,
                         ),
                     ),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'description',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 0,
                             'max'      => 500,
                         ),
                     ),
                 ),
             ));

             $inputFilter->add(array(
                 'name'     => 'instructions',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'StripTags'),
                     array('name' => 'StringTrim'),
                 ),
                 'validators' => array(
                     array(
                         'name'    => 'StringLength',
                         'options' => array(
                             'encoding' => 'UTF-8',
                             'min'      => 1,
                             'max'      => 5000,
                         ),
                     ),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'duration',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                    array(
                        'name' => 'GreaterThan',
                        'options' => array(
                            'min' => 0,
                            'inclusive' => false,
                            'message' => 'Please choose a duration greater than 0!',
                        )
                    ),
                ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'difficultyID',
                 'required' => true,
             ));
             
             //TODO: enough filtering for difficultyID?

             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

}