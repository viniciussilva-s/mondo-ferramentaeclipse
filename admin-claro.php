<?php 

use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Prev_registers;



$app->post('/admin/dontkeep/claro-create', function() {
  User::verifyLogin();
  $prev_registers = new Prev_registers();
  $_POST['keep_content']= 0; 
  $prev_registers->setData($_POST);
  $prev_registers->save();

  exit(); 

});

$app->post('/admin/claro-create', function() {
  User::verifyLogin();
  $prev_registers = new Prev_registers();
  $_POST['keep_content']= 1; 
  $_POST['description']= ''; 

  $prev_registers->setData($_POST);
  $prev_registers->save();
  exit; 

});

