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
    
    public function addAction(){
         $form = new LoginForm();
         $form->get('loginsubmit')->setValue('Login');
         $request = $this->getRequest();
         
         if ($request->isPost()) {
             $login = new Login();
             $form->setInputFilter($login->getInputFilter());
             $form->setData($request->getPost());
             
             if ($form->isValid()) {
                 $uid = (string)$form->get('loginid')->getValue();
                 $p = (string)$form->get('loginpassword')->getValue();
               
                 $rs = getResultSet("User");
                 foreach ($rs as $row) {
                      if(strcmp($uid,(string)$row['userID'])==0 && strcmp($p,(string)$row['password'])==0){
                          login($uid);
                         
                          return $this->redirect()->toRoute('recipe', array('action' => 'index'));
                      }
                 }
                 echo "<script>alert('Error: Wrong user id or password!');</script>";
             }
        }
        return array('form' => $form);
    }
 
}

 //...