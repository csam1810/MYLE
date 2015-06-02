<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *  * CVL ins
 * Description of Lists (NOT LIST)
 * assumption createUserID is filled
 * TODO get all fields for display
 */
 

namespace Recipe\Model;
 use Zend\InputFilter\InputFilterAwareInterface;    //CVL necessary?
 use Zend\InputFilter\InputFilterInterface;         //CVL necessary?
 use Zend\InputFilter\InputFilter;                  //CVL necessary


class Lists{
    //class Lists implements InputFilterAwareInterface {    //CVL necessary
    public $listID;
    public $createUserID;
    
    public function exchangeArray($data) {
        $this->listID  = (!empty($data['listID'])) ? $data['listID'] : null;
        $this->createUserID    = (!empty($data['createUserID'])) ? $data['createUserID'] : null;
    }
}
