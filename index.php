<?php 
session_start();

require_once("vendor/autoload.php");
use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once('admin.php');
require_once('admin-user.php');
require_once('functions.php');
require_once('configsite.php');
require_once('admin-claro.php');//script para CRUD do menu 
require_once('admin-configure-menu.php'); // configurar opções e alternativas de menu 
require_once('admin-way.php');
require_once('admin-links.php');
require_once('admin-secondpage.php');
$app->run();

 ?>