<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// module/Album/src/Album/Controller/CreateAccountController.php:

 //...
 namespace Createaccount\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Createaccount\Model\Createaccount;          // <-- Add this import
 use Createaccount\Form\CreateaccountForm;       // <-- Add this import
//...

 class CreateaccountController extends AbstractActionController
 {
     protected $createaccountTable;
     
     public function getCreateaccountTable()
     {
         if (!$this->createaccountTable) {
             $sm = $this->getServiceLocator();
             $this->createaccountTable = $sm->get('Createaccount\Model\CreateaccountTable');
         }
         return $this->createaccountTable;
     }
     
     public function indexAction()
     {
         return new ViewModel(array(
             'users' => $this->getCreateaccountTable()->fetchAll(),
         ));
     }

     public function addAction()
     {
         $form = new CreateaccountForm();
         $form->get('createAccountsubmit')->setValue('Submit');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $createAccount = new Createaccount();
             $form->setInputFilter($createAccount->getInputFilter());
             $form->setData($request->getPost());

             if ($form->isValid()) {
                 $uid = (string)$form->get('createAccountid')->getValue();
                 $dn = (string)$form->get('displayName')->getValue();
                 $pn = (string)$form->get('phoneNo')->getValue();
                 $p = (string)$form->get('createAccountpassword')->getValue();
                 $rp = (string)$form->get('repassword')->getValue();
                 $rs = getResultSet("User");
                 foreach ($rs as $row) {
                      if(strcmp($uid,(string)$row['userID'])==0){
                            echo "<script>alert('Error: User id dose exist!');</script>";
                            goto out;
                      }
                 }
                 if(strcmp($p,$rp)==0){
                    executeQuery("INSERT INTO User(userID, displayName, phoneNo, password) VALUES ('" . $uid . "','" . $dn . "','" . $pn . "','" . $p . "')");
                    echo "<script>alert('User successfully created!');</script>";
                    login($uid);
                    return $this->redirect()->toRoute('recipe', array('action' => 'index'));
                 }
                 else{
                     echo "<script>alert('Error: Password and Re-Password do not match!');</script>";
                 }
             }
             out:
        }
        
        return array('form' => $form);
     }
             
 }

 //...