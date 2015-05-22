<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 return array(
     'controllers' => array(
         'invokables' => array(
             'Createaccount\Controller\Createaccount' => 'Createaccount\Controller\CreateaccountController',
         ),
     ),
     
     // The following section is new and should be added to your file
     'router' => array(
         'routes' => array(
             'createaccount' => array(
                 'type'    => 'segment',
                 'options' => array(
                     'route'    => '/createaccount[/:action][/:id]',
                 //    'constraints' => array(
                 //        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                  //       'id'     => '[0-9]+',
                  //   ),
                     'defaults' => array(
                         'controller' => 'Createaccount\Controller\Createaccount',
                         'action'     => 'add',
                     ),
                 ),
             ),
         ),
     ),

     
     'view_manager' => array(
         'template_path_stack' => array(
             'createaccount' => __DIR__ . '/../view',
         ),
     ),
 );