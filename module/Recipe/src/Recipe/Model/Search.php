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


 class Search implements InputFilterAwareInterface
 {

     public $searchTerm;    
     public $duration; 
     public $typeOfSearch;
     
     protected $inputFilter;

     //this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
    {                  
         $this->searchTerm  = (!empty($data['searchTerm'])) ? $data['searchTerm'] : null;
         $this->duration = (!empty($data['duration'])) ? $data['duration'] : null; 
         $this->typeOfSearch = (!empty($data['typeOfSearch'])) ? $data['typeOfSearch'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }
    
     /**
      * no field in search is mandatory
      */
    public function getInputFilter() {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();            
    
             //same length as recipeName
                $inputFilter->add(array(
                 'name'     => 'searchTerm',
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
                             'max'      => 255,
                         ),
                     ),
                 ),
             ));
                                                
                  $inputFilter->add(array(
                 'name'     => 'duration',
                 'required' => false,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                    array(                        
                        'name' => 'isInt',
                        'options' => array(
                            'min' => 0,
                            'inclusive' => false,
                            'message' => 'Please choose a duration greater than 0!',
                        )
                    ),
                ),
             ));
                
             
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

}