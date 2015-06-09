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
     
     protected $inputFilter;

     //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
    {         
         $this->searchTerm  = (!empty($data['searchTerm'])) ? $data['searchTerm'] : null;
     }
     
     public function getArrayCopy()
     {
         return get_object_vars($this);
     }


    public function getInputFilter() {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();            
    
             //CVL5, same length as recipeName
                $inputFilter->add(array(
                 'name'     => 'searchTerm',
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
             
             $this->inputFilter = $inputFilter;
         }

         return $this->inputFilter;

    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

}