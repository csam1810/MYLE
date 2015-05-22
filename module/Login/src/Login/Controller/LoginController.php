<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

// module/Album/src/Album/Controller/LoginController.php:

 //...
 namespace Login\Controller;
 
 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Login\Model\Login;          // <-- Add this import
 use Login\Form\LoginForm;       // <-- Add this import
//...

 class LoginController extends AbstractActionController
 {
     protected $loginTable;
     
     public function getLoginTable()
     {
         if (!$this->loginTable) {
             $sm = $this->getServiceLocator();
             $this->loginTable = $sm->get('Login\Model\LoginTable');
         }
         return $this->loginTable;
     }
     
     public function indexAction()
     {
         return new ViewModel(array(
             'users' => $this->getLoginTable()->fetchAll(),
         ));
     }
  
     public function addAction()
     {
         
         $form = new LoginForm();
         $form->get('loginsubmit')->setValue('Login');

         $request = $this->getRequest();
         if ($request->isPost()) {
             $login = new Login();
             $form->setInputFilter($login->getInputFilter());
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
                 
                 $loginid = $form->get('loginid')->getValue();
                 $loginpassword = $form->get('loginpassword')->getValue();
                 
                 foreach ($users as $user){
                     if(strcmp($loginid,$user->ID)==0 && strcmp($loginpassword,$user->Password)==0){
                        return $this->redirect()->toRoute('album', array('action' => 'recipe'));
                     }
                 }
                 
                // $login->exchangeArray($form->getData());
                // $this->getLoginTable()->saveLogin($login);

                 // Redirect to login
                 return $this->redirect()->toRoute('login');
             }
         }
         return array('form' => $form);
     }
 }

 //...