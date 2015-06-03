<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 return array(
     'controllers' => array(
         'invokables' => array(
             'Recipe\Controller\Recipe' => 'Recipe\Controller\RecipeController',
             'DifficultyFieldset' => 'Recipe\Form\DifficultyFieldset',
             'Recipe\Controller\List' => 'Recipe\Controller\RecipeController', //ins CVL3 ???
         ),
     ),
     
     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'recipe' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/recipe[/:action][/:recipeID]',
                     'constraints' => array(
                         'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                         'recipeID'     => '[0-9]+',
                     ),
                     'defaults' => array(
                         'controller' => 'Recipe\Controller\Recipe',
                         'action'     => 'index',
                     ),
                 ),
             ),
             
              'list' => array(
                 'type'    => 'literal',
                 'options' => array(
                     'route'    => '/list',                                        
                     'defaults' => array(
                         'controller' => 'Recipe\Controller\Recipe',
                         'action'     => 'view-list',                     
                 ),
             ),
         ),
     ),
),

     
     'view_manager' => array(
         'template_path_stack' => array(
             'recipe' => __DIR__ . '/../view',
         ),
     ),
 );