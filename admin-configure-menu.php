<?php 

use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Funcionario;
use \vCode\Model\ConfigureMenu;
use \vCode\Model\Logs;
use \vCode\Model\Menu;

// $app->get('/admin/config-opt/claro', function() 
// {
//   User::verifyLogin();
//   $con = new ConfigureMenu();
//   $configuremenu = ConfigureMenu::listAllOptions(); 

//   $search = isset($_GET['search'])?$_GET['search'] : '';
//   if(isset($search) && !empty($search)){
//     $configuremenu = ConfigureMenu::listAllOptions($search); 
//   }

//   $page = new PageAdmin();

//  $page->setTpl('options',array(
//         'configuremenu' => $configuremenu
//     ));
// });

// $app->post('/admin/config-opt/claro', function() 
// {
//   User::verifyLogin();
//   $nconfigMenu = new ConfigureMenu() ;
//   $nconfigMenu->setData($_POST);
//   $nconfigMenu->setOptionMenu();

//   header('Location: /desv/desenUserLogin/index.php/admin/config-opt/claro');
//   exit;
// });

// $app->post('/admin/config-opt/claro/edit/:id_option', function($id_option) 
// {
//   User::verifyLogin();
//   $id_option = $_POST['id_option'] ; 
//   if(isset($id_option)&& !empty($id_option)  ){
//     $nconfigMenu = new ConfigureMenu();
//     $nconfigMenu->getOption($id_option);
//     $nconfigMenu->saveOption($_POST);
//   } else{
//      Information::setError_record('Há identificação inválida');
//   }
//   header('Location: /desv/desenUserLogin/index.php/admin/config-opt/claro');
//   exit;
// });
// $app->get('/admin/config-opt/claro/delete/:id_option', function($id_option) 
// {
//   User::verifyLogin();
//     $nconfigMenu = new ConfigureMenu();
//     $nconfigMenu->getOption($id_option);
//     $nconfigMenu->deleteOption();
//   header('Location: /desv/desenUserLogin/index.php/admin/config-opt/claro');
//   exit;
// });

// Configuração para Alternativas --------------------------------------------------------*
$app->get('/admin/config-alt/claro/onlyAdmin', function() 
{
  User::verifyLogin();
  $options = ConfigureMenu::listAllOptions(); 

  $page = new PageAdmin();
  $page->setTpl('opcoes-cadastro',array(
    'options'=>$options,
    'layout'=>'cad' 
  ));
});

$app->post('/admin/config-alt/claro/post', function() 
{
  User::verifyLogin();

  $configMenuAlternative = new ConfigureMenu() ;
  $configMenuAlternative->setData($_POST);
  $configMenuAlternative->setAlternativeMenu();

  //header('Location: /desv/desenUserLogin/index.php/admin/config-alt/claro');
  exit;
});

$app->get('/admin/list/config-alt/claro/onlyAdmin', function() {

  User::verifyLogin();

  $page = new PageAdmin();
//ConfigureMenu::getMenuAlternatives();

  $page->setTpl('opcoes-lista',array(
    'listOption'=>ConfigureMenu::getMenuAlternatives()

  ));




});

$app->get('/admin/config-alt/:id_option/claro/onlyAdmin', function($id_option) {

  User::verifyLogin();
  if(isset($id_option) && !empty($id_option)){
      $options = ConfigureMenu::getOption($id_option); 

  }

  $page = new PageAdmin();
  $page->setTpl('opcoes-cadastro',array(
    'options'=>$options,
    'layout'=>'alt' 
  ));


});
$app->post('/admin/config-alt/claro/edit/:id_alt/onlyAdmin', function($id_alt) 
{
  User::verifyLogin();

  //$id_alt = $_POST['id_alt'] ; 
  if(isset($id_alt)&& !empty($id_alt)  ){
    $nconfigMenu = new ConfigureMenu();
    $nconfigMenu->getAlternative($id_alt);
    $nconfigMenu->saveAlternative($_POST);
  } else{
   Information::setError_record('Há identificação inválida');
 }

 
 exit;
});
$app->get('/admin/config-alt/claro/delete/:id_option', function($id_option) 
{
  User::verifyLogin();
    $nconfigMenu = new ConfigureMenu();
    $nconfigMenu->getAlternative($id_option);
    $nconfigMenu->deleteAlternative();
  exit;
});





