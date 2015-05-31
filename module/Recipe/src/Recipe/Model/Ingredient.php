<?php

/**
 * Description of Ingredient
 *
 * @author alexandra
 */

namespace Recipe\Model;

 use Zend\InputFilter\InputFilterAwareInterface;
 use Zend\InputFilter\InputFilterInterface;
 use Zend\InputFilter\InputFilter;

class Ingredient implements InputFilterAwareInterface {
    public $ingredientID;
    public $ingredientName;
    public $createUserID;
    
    protected $inputFilter;
    
    //AJ: this method is needed to work with Zend's TableGateway class
     public function exchangeArray($data)
     {
         $this->ingredientID  = (!empty($data['ingredientID'])) ? $data['ingredientID'] : null;
         $this->ingredientName    = (!empty($data['ingredientName'])) ? $data['ingredientName'] : null;
         $this->createUserID  = (!empty($data['createUserID'])) ? $data['createUserID'] : null;
     }
     
     public function getInputFilter() {
         if (!$this->inputFilter) {
             $inputFilter = new InputFilter();

             $inputFilter->add(array(
                 'name'     => 'id',
                 'required' => true,
                 'filters'  => array(
                     array('name' => 'Int'),
                 ),
             ));
             
             $inputFilter->add(array(
                 'name'     => 'createUserID',
                 'required' => true,
             ));

             $inputFilter->add(array(
                 'name'     => 'ingredientName',
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
