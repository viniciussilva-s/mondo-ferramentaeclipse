<?php 

use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Funcionario;


$app->get('/admin/release/:iduser/access/onlyAdmin', function($iduser){
    User::verifyLogin();
  if (isset($iduser) && !empty($iduser) ) {
      User::release_access($iduser);
     User::movelocationUser("/user/onlyAdmin");
     exit();
  }
});
$app->get('/admin/user/onlyAdmin', function() {
  User::verifyLogin();
    
    $page = new PageAdmin();
     $page->setTpl('solicitacoes', array(
      'users_requests'=>User::listAll(true),
      'users'=>User::listAll()
      ));
});

 
$app->get('/admin/reset/:iduser/password/onlyAdmin', function($iduser) {
  User::verifyLogin();
    $user = new User();
    $user->getIduser($iduser);
    $user->resetPassword();
 
    User::movelocationUser("/user/onlyAdmin");
    exit;
});
 
$app->post('admin/alter/:iduser/permission/onlyAdmin', function($iduser) {
  User::verifyLogin();
  $user = new User();
  if($user->getIduser($iduser)){
    $user->alterPermission($_Post);
  }
    User::movelocationUser("/user/onlyAdmin");
    exit;
});