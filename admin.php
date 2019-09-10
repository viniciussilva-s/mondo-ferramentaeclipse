	<?php

	use \vCode\PageAdmin;
	use \vCode\Model\User;
	use \vCode\Model\Information;
	use \vCode\Model\Layout;


	$app->get('/admin', function() {
		User::verifyLogin();
		$page = new PageAdmin();
		$user= isset($_SESSION[User::SESSION])?$_SESSION[User::SESSION]:'0'; 
		$page->setTpl('index');
	});

	$app->get('/admin/login', function() {
		$page= new PageAdmin([
			"header"=> false,
			"footer"=> false
		]);
		$page->setTpl('login-claro',array(
			"enabled"=>'login'
		));

	});
	$app->post('/admin/login', function() {
		User::login($_POST['login'],$_POST['despassword']);
		
	});
	$app->get('/admin/logout', function() {
		User::logout();
		//header("Location: /desv/desenUserLogin/index.php/admin/login");
		User::movelocationUser('/login');
		exit;
	});
	$app->get('/admin/nuser', function() {
		$page= new PageAdmin([
			"header"=> false,
			"footer"=> false
		]);
		$page->setTpl('login-claro',array(
			"enabled"=>"created"
		));		
	});
	$app->post('/admin/nuser', function() {

		print_r($_POST);
		if(!User::isexistsUser($_POST)){
			//header("Location: ".SystemConfigure::BASEURL."index.php/admin/nuser");			
			User::movelocationUser('/nuser');
		}else{
			User::movelocationUser('/usernull');
		}

		exit;
	});

	$app->get('/admin/usernull',function(){

		$page= new PageAdmin([
			"header"=> false,
			"footer"=> false
		]);
		$page->setTpl('login-claro',array(
			"enabled"=>"usernull"
		));		}

	);
