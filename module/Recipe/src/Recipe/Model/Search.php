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
     //CVL9 public $duration;    
     
     protected $inputFilter;

     //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
    {                  
         $this->searchTerm  = (!empty($data['searchTerm'])) ? $data['searchTerm'] : null;
         //CVL9 $this->duration = (!empty($data['duration'])) ? $data['duration'] : null; //CVL7
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
                 'required' => true,           //CVL7, false? because only duration should be possible
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
                /*//CVL9 
                //CVL7 - same as in recipe
                  $inputFilter->add(array(
                 'name'     => 'duration',
                 'required' => false,
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
             ));*/
                
             
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

}