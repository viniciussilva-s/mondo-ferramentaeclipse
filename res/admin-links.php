<?php 
use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Prev_registers;
use \vCode\Model\Way;
use \vCode\Model\Links;
use \vCode\Model\ConfigureMenu;
use \vCode\Model\Information;

//   /way/:id_way/links
$app->get('/admin/way/none/links', function() {
	User::verifyLogin();
	$page = new PageAdmin();
	$way = new Way(); 
	$oneWay = '';
	$dataLinks = '';

	if(Way::verifyWay()) {
		$oneWay = Way::getOneWay();
		$dataLinks = Links::getListAll_Links((int)$_SESSION[Way::IDENTIFYWAY]);
	}

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['3']['status']='active';
	$stepsmenu['0']['href']='#';

print_r($_SESSION);



	$page->setTpl('definir-link',array(
		'way'=>$oneWay, 
		'listAllOptions'=> ConfigureMenu::listAllOptions(),
		'dataLinks'=>$dataLinks,
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu),
		'id_way'=>''


	));
});

$app->post('/admin/way/none/links', function() {
	User::verifyLogin();

	$links = new Links();
	if(isset($_POST) && !empty($_POST)){
		$dataOrigem = $links->getDuplicidadeWay();
		$links->formatDuplicidade($dataOrigem , $_POST);
		
	}
	Links::movelocationUser("/way/none/links");
	exit();

});
$app->post('/admin/way/duplicate/none/links', function() {
	User::verifyLogin();

	$links = new Links();
	if(isset($_SESSION[Links::IDENTIFYLINK])){
		if(isset($_POST) && !empty($_POST)){

			//$dataOrigem = $links->getDuplicate($_SESSION[Links::IDENTIFYLINK]);
			$dataOrigem = $links->getDuplicidadeWay();
			
			$links->formatDuplicidade($dataOrigem , $_POST);

		}

	}
	Links::movelocationUser("/way/none/links");
	exit();
	

});	










$app->get('/admin/way/claro/:id_way/links', function($id_way) {
	User::verifyLogin();
	$page = new PageAdmin();

	if(!empty($id_way) ){
		$data = Way::getway($id_way,true);
		if(isset($data['0']['id_way'])){
			//$way = new Way($data['0']['id_way']);  	
			$way = new Way($data['0']['id_way']);  	
		}
		
	}
	$oneWay = '';
	$dataLinks = '';


	if(Way::verifyWay()) {
		$oneWay = Way::getOneWay();
		$dataLinks = Links::getListAll_Links((int)$_SESSION[Way::IDENTIFYWAY]);
	}

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['3']['status']='active';
	$stepsmenu['0']['href']='#';


	$page->setTpl('definir-link',array(
		'way'=>$oneWay, 
		'listAllOptions'=> ConfigureMenu::listAllOptions(),
		'dataLinks'=>$dataLinks,
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu),
		'id_way'=>$data['0']['id_way'] 



	));
});





// /desv/desenUserLogin/index.php/admin/way/claro/duplicate/{$id_way}/links

$app->post('/admin/way/claro/duplicate/:id_way/links', function($id_way) {
	User::verifyLogin();

	$links = new Links();
	if(!empty($id_way) ){
		$data = Way::getway($id_way,true);
		if(isset($data['0']['id_way'])){
			//$way = new Way($data['0']['id_way']);  	
			$way = new Way(['0']['id_way']);  
		}
	}
	if(isset($_SESSION[Links::IDENTIFYLINK])){
		if(isset($_POST) && !empty($_POST)){

			$dataOrigem = $links->getDuplicate($_SESSION[Links::IDENTIFYLINK]);
			
			$links->formatDuplicidade($dataOrigem , $_POST);

		}

	}
	Links::movelocationUser("/way/claro/{$id_way}/links");
	exit();
	

});	

// /desv/desenUserLogin/index.php/admin/way/claro/{$id_way}/links
$app->post('/admin/way/claro/:id_way/links', function($id_way) {
	User::verifyLogin();

	if(!empty($id_way) ){
		$data = Way::getway($id_way,true);
		if(isset($data['0']['id_way'])){
			//$way = new Way($data['0']['id_way']);  	
			$way = new Way($data['0']['id_way']);
			if(isset($_POST) && !empty($_POST)){
				Links::setLinksAlternativs($_POST);
			}
			Links::movelocationUser("/way/claro/{$id_way}/links");
			exit();  
		}
	}
	

});



