<?php 
use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Prev_registers;
use \vCode\Model\Way;
use \vCode\Model\Links;
use \vCode\Model\ConfigureMenu;
use \vCode\Model\Seconds;
use \vCode\Model\Information;

$app->get('/admin/way/pageseconds/none', function() {
	User::verifyLogin();
	$page = new PageAdmin();
	$way = new Way(); 
	$oneWay = '';
	$dataSecondsPages = '';

	if(Way::verifyWay( )) {
		$oneWay = Way::getOneWay();
		$dataSecondsPages = Seconds::getListAll_secondspages((int)$_SESSION[Way::IDENTIFYWAY]);
	}

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['2']['status']='active';
	$stepsmenu['0']['href']='#';
	$page->setTpl('definir-secundaria',array(
		'way'=>$oneWay, 
		'listAllOptions'=> ConfigureMenu::listAllOptions(),
		'datasecondspages'=>$dataSecondsPages,
		'stepsmenu'=>Prev_registers::formatStepsMenu($stepsmenu),
		'id_way'=>'' 
	));
});
$app->post('/admin/way/pageseconds/none', function() {
	User::verifyLogin();
	if(isset($_POST) && !empty($_POST)){
		Seconds::setSecondsAlternatives($_POST);
	}
	Seconds::movelocationUser("/way/pageseconds/none");
	exit();

});
$app->post('/admin/way/pageseconds/duplicate/none', function() {
	User::verifyLogin();

	$seconds = new Seconds();
	
	if(isset($_SESSION[Seconds::IDENTIFYSECONDS])){
		if(isset($_POST) && !empty($_POST)){
			// $dataOrigem = $seconds->getDuplicate($_SESSION[Seconds::IDENTIFYSECONDS]);
			// $seconds->formatDuplicidade($dataOrigem , $_POST);
			Seconds::setSecondsAlternatives($_POST);
			
		}
	}	
	Seconds::movelocationUser("/way/pageseconds/none");
	exit();

});	



$app->get('/admin/claro/way/:id_way/pageseconds', function($id_way) {
	User::verifyLogin();
	$page = new PageAdmin();
	if(!empty($id_way) ){
		$way = new Way($id_way);
		$data = Way::getway($id_way,true);
	}

	$oneWay = '';
	$dataSecondsPages = '';

	if(Way::verifyWay( )) {
		$oneWay = Way::getOneWay();
		$dataSecondsPages = Seconds::getListAll_secondspages((int)$_SESSION[Way::IDENTIFYWAY]);
	}
	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['2']['status']='active';
	$stepsmenu['0']['href']='#';
	$page->setTpl('definir-secundaria',array(
		'way'=>$oneWay, 
		'listAllOptions'=> ConfigureMenu::listAllOptions(),
		'datasecondspages'=>$dataSecondsPages,
		'stepsmenu'=>Prev_registers::formatStepsMenu($stepsmenu),
		'id_way'=>$data['0']['id_way'] 

	));

});

$app->post('/admin/claro/way/:id_way/pageseconds', function($id_way) {
	User::verifyLogin();
	

	if(!empty($id_way) ){
		$way = new Way($id_way);
		$data = Way::getway($id_way,true);
			if(isset($_POST) && !empty($_POST)){
				Seconds::setSecondsAlternatives($_POST);
			}	
		Seconds::movelocationUser("/claro/way/{$id_way}/pageseconds");
		exit();
	}
});

$app->post('/admin/way/claro/pageseconds/:id_way/duplicate', function($id_way) {
	User::verifyLogin();

	$seconds = new Seconds();

	if(!empty($id_way) ){
		$way = new Way($id_way);
		$data = Way::getway($id_way,true);
			if(isset($_SESSION[Seconds::IDENTIFYSECONDS])){
				if(isset($_POST) && !empty($_POST)){

					// $dataOrigem = $seconds->getDuplicate($_SESSION[Seconds::IDENTIFYSECONDS]);
					// $seconds->formatDuplicidade($dataOrigem , $_POST);
					Seconds::setSecondsAlternatives($_POST);

				}
			}	
			Seconds::movelocationUser("/claro/way/{$id_way}/pageseconds");
			exit();
	}	
});	

$app->get("/admin/way/pageseconds/delete/:id_secpages",function($id_secpages){
	User::verifyLogin();

	if(isset($id_secpages) && !empty($id_secpages)){
		$seconds = Seconds::getSecondsPages($id_secpages , true);
		if(count($seconds)>0){
				Seconds::deletSeconds($seconds['0']['id_sec']);
			if(isset($_GET['location']) && !empty($_GET['location']) ){
				Seconds::movelocationUser($_GET['location']);	
			}else{
				echo "local vazio";
			}			
		}else{
			echo "Identificador não encontrado";
		}
	}else{
		echo "Identificador vazio";
	}
});


$app->get("/admin/way/edit/pageseconds/:id_secpages",function($id_secpages){
	User::verifyLogin();
	$page = new PageAdmin();
	
	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['2']['status']='active';
	$stepsmenu['0']['href']='#';
	$secpagesdata = '' ; 
	if(isset($id_secpages) && !empty($id_secpages)){
		$secpagesdata = Seconds::getSecondsPages($id_secpages , true); 
		if(!count($secpagesdata)>0){
			Information::setError_record('Não encontrado a Página Secundária'); 
		}	
	}else{
		Information::setError_record('Não Encontrado o identificador');
	}

	$page->setTpl("alterar-element",array(
		'stepsmenu'=>Prev_registers::formatStepsMenu($stepsmenu),
		"title"=>"Alterar Página Secundária",
		"layout"=>"alt-pageseconds",
		"secpagesdata"=>$secpagesdata

	));
});
$app->post("/admin/way/edit/pageseconds/:id_secpages",function($id_secpages){

	User::verifyLogin();
	if(isset($id_secpages) && !empty($id_secpages)){
		$secpagesdata = Seconds::getSecondsPages($id_secpages , true); 
		if(count($secpagesdata)>0){
			Seconds::updateSecondsPage($secpagesdata,$_POST);
			Seconds::movelocationUser("/claro/way/{$secpagesdata['0']['id_way']}/pageseconds");	
		}else{
			Information::setError_record('Não encontrado a Página Secundária'); 
		}	
	}else{
		Information::setError_record('Não Encontrado o identificador');
		
	}

});