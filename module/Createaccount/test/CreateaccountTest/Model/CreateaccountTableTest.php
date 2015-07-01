<?php

namespace Createaccount\Model;

use PHPUnit_Framework_TestCase;
use Createaccount\Model\CreateaccountTable;
use Createaccount\Model\Createaccount;

include 'config/autoload/functions.php';

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
            'repassword' => 123,
        );
      $rs = getResultSet("User");
        foreach ($rs as $row) {
                      if(strcmp($data['userID'] ,(string)$row['userID'])==0){
                            echo "<script>alert('Error: User id dose exist!');</script>";
                            goto out;
                      }
                 }
                 if(strcmp($data['password'] ,$data['repassword'] )==0){
                    $str= "INSERT INTO User(userID, displayName, phoneNo, password) VALUES ('";
                    executeQuery($str . $data['userID'] . "','" . $data['displayName'] . "','" . $data['phoneNo'] . "','" . $data['password'] . "')");
                    echo "<script>alert('User successfully created!');</script>";
                    login($data['userID']);
                 }
                 else{
                     echo "<script>alert('Error: Password and Re-Password do not match!');</script>";
                 }
        out:
            
    /*    $rs = getResultSet("User");
        foreach ($rs as $row) {
                      if(strcmp($data->userID ,(string)$row['userID'])==0){
                            echo "<script>alert('Error: User id dose exist!');</script>";
                            goto out;
                      }
                 }
                 if(strcmp($data->password ,$data->repassword )==0){
                    $str= "INSERT INTO User(userID, displayName, phoneNo, password) VALUES ('";
                    executeQuery($str . $data->userID . "','" . $data->displayName . "','" . $data->phoneNo . "','" . $data->password . "')");
                    echo "<script>alert('User successfully created!');</script>";
                    login($data->userID);
                    return $this->redirect()->toRoute('recipe', array('action' => 'index'));
                 }
                 else{
                     echo "<script>alert('Error: Password and Re-Password do not match!');</script>";
                 }
        out:
     * 
     */
   /*
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
    * 
    */

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
