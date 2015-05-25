<?php
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;

session_start();
if(isset( $_SESSION['user'])){
      $_SESSION['user'] = "";
}

function login($uid){
    $_SESSION['user'] = $uid;
}

function logout(){
    $_SESSION['user'] = "";
}

function getLoginDisplayName(){
    if($_SESSION['user']==""){
        return "";
    }
    else{
         $db = getAdapter();
         $statement = $db->createStatement("SELECT displayName FROM user WHERE userID='" . $loginUser . "'");
         $result = $statement->execute();
         $rs = new ResultSet;
         $rs->initialize($result);
         foreach ($rs as $row) {
                return $row['displayName'];
         }
    }
}

function getAdapter(){
    $db = new Zend\Db\Adapter\Adapter(array(
         'driver'         => 'Pdo',
         'dsn'            => 'mysql:dbname=RecipeTestDB;host=localhost',
         'username' => 'root',
         'password'=>'',
         'driver_options' => array(
             PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
         ),
    ));
    return $db;
}

function executeQuery($sql){
    $db = getAdapter();
    $statement = $db->createStatement($sql);
    $result = $statement->execute();
    return $result;
}

function getResultSet($tbn){
    $db = getAdapter();
    $statement = $db->createStatement('SELECT * FROM ' . $tbn);
    $result = $statement->execute();
 
    if ($result instanceof ResultInterface && $result->isQueryResult()) {
        $resultSet = new ResultSet;
        $resultSet->initialize($result);
       
        $myResults = array();
        foreach ($resultSet as $myResult) {
            $myResults[] = $myResult;
        }
        return $myResults;
    }  
}

