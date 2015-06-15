<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//CVL5
namespace Recipe\Model;

 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 use Zend\InputFilter\InputFilter;


 class Search implements InputFilterAwareInterface
 {

     public $searchTerm;    
     public $duration; 
     public $typeOfSearch; //ins CVL10
     
     protected $inputFilter;

     //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
    {                  
         $this->searchTerm  = (!empty($data['searchTerm'])) ? $data['searchTerm'] : null;
         $this->duration = (!empty($data['duration'])) ? $data['duration'] : null; //CVL7
         $this->typeOfSearch = (!empty($data['typeOfSearch'])) ? $data['typeOfSearch'] : null; //CVL10
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }

//CVL8 min from 3 -> 0 in order to search only for duration as well
    public function getInputFilter() {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();            
    
             //CVL5, same length as recipeName
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
                
                //CVL10 - no output when not valid due to using same page for input and result of search
                //CVL10 - validator that number has to be > 0, not negative
                
                //CVL10 isInt is also availabel instead of GreaterThan
                  $inputFilter->add(array(
                 'name'     => 'duration',
                 'required' => false, //CVL11 
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
                 'validators' => array(
                    array(
                        //'name' => 'GreaterThan', //del CVL11, should be greater than but then error if invalid
                        'name' => 'isInt', //ins CVL11
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