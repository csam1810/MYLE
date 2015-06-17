<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Recipe\Model;

 use Zend\Db\TableGateway\TableGateway;
 use Zend\Db\TableGateway\AbstractTableGateway;
 use Zend\Db\Adapter\Driver\ResultInterface;    //ins CVL6
 use Zend\Db\ResultSet\ResultSet;                //ins CVL6

 class RecipeTable extends AbstractTableGateway
 {
     protected $tableGateway;

     public function __construct(TableGateway $tableGateway)
     {
         $this->tableGateway = $tableGateway;
     }

     public function fetchAll()
     {
         $resultSet = $this->tableGateway->select(function($select) {
            $select->order('createDate DESC');
            // insert some awesome ordering magic here..!
        });
        return $resultSet;
     }

     public function getRecipe($recipeID)
     {
         $recipeID  = (int) $recipeID;
         $rowset = $this->tableGateway->select(array('recipeID' => $recipeID));
         $row = $rowset->current();
         if (!$row) {
             throw new \Exception("Could not find row $recipeID");
         }
         return $row;
     }
     
     /*CV: ins 
      * get recipes by name
      * result can be >=0 => set of recipes
      * search for recipes where searchTerm is substring of recipeName      
        "SELECT * FROM student WHERE name LIKE '%John%'";    
     //CVL5*/
    
      public function getRecipeByName($searchTerm)
     {
      
         //search exactly by name, obsolet
         //$rowset = $this->tableGateway->select(array('recipeName' => $searchTerm)); 
         
        //begin of ins CVL6
         $db = getAdapter();
         //is working: $statement = $db->createStatement("SELECT * FROM Recipe WHERE recipeName='" . $searchTerm . "'");         
         $statement = $db->createStatement("SELECT * FROM Recipe WHERE recipeName LIKE '%".$searchTerm."%'");
         $result = $statement->execute();
         $rowset = new ResultSet;
         $rowset->initialize($result);
         
         //alternative but adapter missing
         //http://framework.zend.com/manual/current/en/modules/zend.db.sql.html         
          
         //source https://samsonasik.wordpress.com/2013/01/15/zend-framework-2-cheat-sheet-zenddb/
      //$rowset = $this->select(function (Sql\Select $select) use ($searchTerm) {                          
          
       //like... 
       //$select->where->like('recipeName', "%$searchTerm%");
       
       //between
       //$select->where->between('id', 2, 5); //identifier,min,max
   
       //NEST
       //$select->where
       //             ->AND->NEST->like('firstname', "%$keyword%")
       //             ->OR->like('lastname', "%$keyword%");
        
      //if you will work with
      //'native' expression, use Sql\Expression
      //$select->where->notequalTo('name', new Sql\Expression('all(select name from othertableagain)'));     
      //or use predicate...
      //$select->where
       //     ->addPredicate(new Sql\Predicate\Expression('LOWER(user_name) = ?',
       //                         strtolower($name)));    
    
//});
    //end of ins CVL6
                  
         return $rowset;         
     }
     
     
     //CVL7
     //duration smaller than
     public function getRecipeByDuration($duration)
     {
         $db = getAdapter();         
         $statement = $db->createStatement("SELECT * FROM Recipe WHERE duration <=".$duration);
         $result = $statement->execute();
         $rowset = new ResultSet;
         $rowset->initialize($result);
               
         return $rowset;         
     }
     
     //CVL7
     //search for recipe name and duration smaller equal than
     public function getRecipeByNameAndDuration($searchTerm, $duration)
     {
         $db = getAdapter();         
         $statement = $db->createStatement("SELECT * FROM Recipe WHERE recipeName LIKE '%".$searchTerm."%' AND duration <=".$duration);
         $result = $statement->execute();
         $rowset = new ResultSet;
         $rowset->initialize($result);
               
         return $rowset;         
     }

     public function saveRecipe(Recipe $recipe)
     {
         $data = array(
             'instructions' => $recipe->instructions,
             'description' => $recipe->description,
             'recipeName'  => $recipe->recipeName,
             'duration' => $recipe->duration,
             'difficultyID' => $recipe->difficultyID,
             'createUserID' => $recipe->createUserID,
         );

         $id = (int) $recipe->recipeID;
         if ($id == 0) {
             $this->tableGateway->insert($data);
             //set ID of newly inserted entity
             $id = $this->tableGateway->lastInsertValue;
         } else {
             if ($this->getRecipe($id)) {
                 $this->tableGateway->update($data, array('recipeID' => $id));
             } else {
                 throw new \Exception('Recipe id does not exist');
             }
         }
         return $id;
     }

     public function deleteRecipe($recipeID)
     {
         $this->tableGateway->delete(array('recipeID' => (int) $recipeID));
     }
 }