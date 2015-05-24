<?php
use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\ResultSet;
//use \Zend_Db;
//require_once 'Zend/Db/Adapter/Pdo/Mysql.php';

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

