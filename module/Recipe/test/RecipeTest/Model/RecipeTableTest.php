<?php

namespace RecipeTest\Model;

use Recipe\Model\RecipeTable;
use Recipe\Model\Recipe;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class RecipeTableTest extends PHPUnit_Framework_TestCase {
    protected $traceError = true;
    
    //Read Test
    public function testFetchAllReturnsAllRecipes() {
        $resultSet = new ResultSet();
        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false
        );
        $mockTableGateway->expects($this->once())
                ->method('select')
                ->with()
                ->will($this->returnValue($resultSet));

        $recipeTable = new RecipeTable($mockTableGateway);

        $this->assertSame($resultSet, $recipeTable->fetchAll());
    }
    
    //delete
    public function testCanDeleteARecipeByItsId() {
        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('delete'), array(), '', false
        );
        $mockTableGateway->expects($this->once())
                ->method('delete')
                ->with(array('recipeID' => 123));

        $recipeTable = new RecipeTable($mockTableGateway);
        $recipeTable->deleteRecipe(123);
    }
    
     //create
    public function testSaveRecipeWillInsertNewRecipesIfTheyDontAlreadyHaveAnId() {
        $recipeData = array(
            'recipeName' => 'Lasagna',
            'description' => 'italian food',
            'instructions' => 'instructions',
            'duration' => 20,
            'difficultyID' => 's',
            'createUserID' => null,
        );
        $recipe = new Recipe();
        $recipe->exchangeArray($recipeData);

        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('insert'), array(), '', false
        );
        $mockTableGateway->expects($this->once())
                ->method('insert')
                ->with($recipeData);

        $recipeTable = new RecipeTable($mockTableGateway);
        $recipeTable->saveRecipe($recipe);
    }
    
    //edit
    public function testSaveRecipeWillUpdateExistingRecipesIfTheyAlreadyHaveAnId() {
        $recipeData = array(
            'recipeID' => 1,
            'recipeName' => 'Lasagna',
            'description' => 'italian food',
            'instructions' => 'instructions',
            'duration' => 20,
            'difficultyID' => 's',
            'createUserID' => null,
        );
        $recipe = new Recipe();
        $recipe->exchangeArray($recipeData);

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Recipe());
        $resultSet->initialize(array($recipe));

        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('select', 'update'), array(), '', false
        );
        $mockTableGateway->expects($this->once())
                ->method('select')
                ->with(array('recipeID' => 1))
                ->will($this->returnValue($resultSet));
        
        $mockTableGateway->expects($this->once())
                ->method('update')
                ->with(
                        array(
                    'recipeName' => 'Lasagna',
                    'description' => 'italian food',
                    'instructions' => 'instructions',
                    'duration' => 20,
                    'difficultyID' => 's',
                    'createUserID' => null,
                        ), array('recipeID' => 1)
        );

        $recipeTable = new RecipeTable($mockTableGateway);
        $recipeTable->saveRecipe($recipe);
    }
    
     public function testExceptionIsThrownWhenGettingNonExistentRecipe() {
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Recipe());
        $resultSet->initialize(array());

        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false
        );
        $mockTableGateway->expects($this->once())
                ->method('select')
                ->with(array('recipeID' => 123))
                ->will($this->returnValue($resultSet));

        $recipeTable = new RecipeTable($mockTableGateway);

        try {
            $recipeTable->getRecipe(123);
        } catch (\Exception $e) {
            $this->assertSame('Could not find row 123', $e->getMessage());
            return;
        }

        $this->fail('Expected exception was not thrown');
    }

    //Read test
    public function testCanRetrieveARecipeByItsId() {
        $recipe = new Recipe();
        $recipe->exchangeArray(array('recipeID' => 123,
            'recipeName' => 'Lasagna',
            'description' => 'italian food',
            'instructions' => 'instructions',
            'duration' => 20,
            'difficultyID' => 's',
            'owner' => null,
            ));

        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Recipe());
        $resultSet->initialize(array($recipe));

        $mockTableGateway = $this->getMock(
                'Zend\Db\TableGateway\TableGateway', array('select'), array(), '', false
        );

        //here is the error!
        $mockTableGateway->expects($this->once())
                ->method('select')
                ->with(array('recipeID' => 123))
                ->will($this->returnValue($resultSet));

        $recipeTable = new RecipeTable($mockTableGateway);

        $this->assertSame($recipe, $recipeTable->getRecipe(123));
    }
}
