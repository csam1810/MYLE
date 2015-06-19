<?php

namespace Createaccount\Model;

use PHPUnit_Framework_TestCase;
use Createaccount\Model\CreateaccountTable;
use Createaccount\Model\Createaccount;

class CreateaccountTableTest extends PHPUnit_Framework_TestCase {

    //create new account
    
    public function testCreateNewAccountWillInsertNewUserIfUserIdDoesNotExist() {
        $data = array(
            'userID' => 'newUserEmail',
            'createDate' => '',
            'UpdateDate' => '',
            'displayName' => 'newUser',
            'phoneNo' => '098767899876',
            'password' => 123,
        );

        $user = new Createaccount();
        $user->exchangeArray($data);     
        
        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false
        );
        $mockTableGateway->expects($this->once())
                ->method('insert')
                ->with($data);

        $userTable = new CreateaccountTable($mockTableGateway);
        $userTable->saveCreateAccount($user);


      /*
        $userRowData = $this->getUser($data->userID);
         if($userRowData !=null){
              echo "User id does exist";
              return $this->redirect()->toRoute('createaccount', array('action' => 'add'));
         }
         else{
              $this->tableGateway->insert($data);
              return $this->redirect()->toRoute('recipe', array('action' => 'index'));
         }
       * 
       */
     
    }
}
