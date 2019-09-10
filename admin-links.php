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
	$way = new way($id_way);
	if(!empty($id_way) ){
		$data = Way::getway($id_way,true);		
	}
	$oneWay = '';
	$dataLinks = '';


	if(Way::verifyWay()){
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
	$way = new way($id_way);
	$links = new Links($id_way);
	

	if(!empty($id_way) ){
		$data = Way::getway($id_way,true);
		if(!empty($data)){
			$dataOrigem = $links->getDuplicidadeWay();
			$links->formatDuplicidade($dataOrigem , $_POST);
		}
	}

	Links::movelocationUser("/way/claro/{$id_way}/links");
	exit();
	

});	

$app->post('/admin/way/claro/:id_way/links', function($id_way) {
	User::verifyLogin();
	
	if(!empty($id_way) ){
		$data = Way::getway($id_way,true);
		if(!empty($data)){
			$way = new Way($id_way);
			//$way = new Way($data['0']['id_way']);  	
			if(isset($_POST) && !empty($_POST)){
				$links = new Links($id_way);
 				$dataOrigem = $links->getDuplicidadeWay();
				$links->formatDuplicidade($dataOrigem , $_POST);
				// Links::setLinksAlternativs($_POST);
			}
			Links::movelocationUser("/way/claro/{$id_way}/links");
			exit();  
		}
	}
	

});

$app->get('/admin/way/links/delete/:id_link',function($id_link){
	User::verifyLogin();
	if(isset($id_link) && !empty($id_link)){
		$link =  Links::getLink($id_link,true); 
		if (count($link)>0)
		{
			Links::deletLink((int)$link['0']['id_link']); 
			if(isset($_GET['location']) && !empty($_GET['location']) ){
				Links::movelocationUser($_GET['location']);	
			}else{
				echo "local vazio";
			}									
		}else{
			echo "Identificador não encontrado";
		}

	}else{
		echo "identificador vazio";
	}
	
});
$app->get("/admin/way/edit/links/:id_link",function($id_link){
	User::verifyLogin();
	$page = new PageAdmin();
	
	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['3']['status']='active';
	$stepsmenu['0']['href']='#';
	$datalink = '' ; 
	if(isset($id_link) && !empty($id_link)){
		$datalink = Links::getLink($id_link , true); 
		if(!count($datalink)>0){
			Information::setError_record('Não encontrado o menus'); 
		}	
	}else{
		Information::setError_record('Não Encontrado o identificador');
	}
	
	$page->setTpl("alterar-element",array(
		'stepsmenu'=>Prev_registers::formatStepsMenu($stepsmenu),
		"title"=>"Alterar Menus",
		"layout"=>"alt-links",
		"datalink"=>$datalink

	));
});
$app->post("/admin/way/edit/links/:id_link",function($id_link){

	User::verifyLogin();
	if(isset($id_link) && !empty($id_link)){
		
		$datalink = Links::getLink($id_link , true); 
		if(count($datalink)>0){
			Links::updateLinks($datalink,$_POST);
			Links::movelocationUser("/way/claro/{$datalink['0']['id_way']}/links");	
		}else{
			Information::setError_record('Não encontrado o Menus p/ alteração '); 
		}	
	}else{
		Information::setError_record('Não Encontrado o identificador');
		
	}

});


