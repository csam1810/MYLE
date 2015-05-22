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
                 $createAccount->exchangeArray($form->getData());
                 $this->getCreateaccountTable()->saveCreateaccount($createAccount);

                 // Redirect to list of createAccount
                 return $this->redirect()->toRoute('createaccount');
             }
         }
         return array('form' => $form);
     }
 }

 //...