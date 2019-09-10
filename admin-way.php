<?php 
use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Prev_registers;
use \vCode\Model\Way;
use \vCode\Model\ConfigureMenu;
use \vCode\Model\Links;
use \vCode\Model\Seconds;



$app->get('/admin/claro/wayall', function() {

	User::verifyLogin();
	$page = new PageAdmin();
	$search = isset($_GET['search'])?$_GET['search'] : '';
	
	$page->setTpl('lista-caminhos-mantidooos',array(
		'way'=>Way::getlistAllWayCreated($search),
		'listAllOptions'=> ConfigureMenu::listAllOptions() 	
	));

});

$app->get('/admin/claro/naomantidos', function() {

	User::verifyLogin();
	$page = new PageAdmin();
	$search = isset($_GET['search'])?$_GET['search'] : '';
	
	$prev_registers = Prev_registers::listAll($search,false); 
	
	
	if(isset($prev_registers) && !empty($prev_registers)){
		foreach ($prev_registers as $key => $value) {
			$prev_registers[$key]['datePrev'] =  date("d/n/y - G:i ", strtotime($prev_registers[$key]['datePrev']))  ;
		}

	}

	$page->setTpl('lista-caminhos-naomantidos',array(
		'prev_registers'=>$prev_registers
	));
});




$app->get('/admin/claro-create', function() {

	User::verifyLogin();

	unset($_SESSION['IDENTIFYWAY']);
	unset($_SESSION['IDENTIFYLINK']);
	unset($_SESSION['MMODIFY']);

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['0']['status']='active';
	$stepsmenu['1']['status']='disabled';
	$stepsmenu['2']['status']='disabled';
	$stepsmenu['3']['status']='disabled';
	$stepsmenu['4']['status']='disabled';

	
	$page = new PageAdmin();  
	$page->setTpl('definir-nova-regra',array(
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu)
	));
});

$app->get('/admin/claro/way/relatorio', function() 
{

	User::verifyLogin();
	$page = new PageAdmin();

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['4']['status']='active';
	$stepsmenu['0']['href']='#';
	$prevregisters = '' ;
	$prevregisters= Prev_registers::getMModifySession();
	$prevregisters['datePrev'] =  date("d/n/y - G:i ", strtotime($prevregisters['datePrev']))  ;

	$page->setTpl('detalhes-caminho',array(
		'listAllOptions'=> ConfigureMenu::listAllOptions() ,	
		'prevregisters' =>$prevregisters,
		'getListAllWay' => Way::listAllWay(),
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu)
	));
});

$app->get("/admin/way/delete/:id_way",function($id_way){
	User::verifyLogin();

	if(isset($id_way) && !empty($id_way)){

		$way = Way::getway($id_way,true);
		if(count($way)>0){
				Way::deletWay($way['0']['id_way']);
			if(isset($_GET['location']) && !empty($_GET['location']) ){
				Way::movelocationUser($_GET['location']);	
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





$app->get('/admin/:idmenu/way', function($idmenu) {
	User::verifyLogin();
	$page = new PageAdmin();
	$dataWay = ''; 
	$mmodify = 0;
	Prev_registers::getIdenficationMenu($idmenu);
	if(isset($_SESSION[Prev_registers::MMODIFY]) && $_SESSION[Prev_registers::MMODIFY] != '0' ) {
		$mmodify = $_SESSION[Prev_registers::MMODIFY];
		$dataWay = Way::getListAllWay($_SESSION[Prev_registers::MMODIFY]); 
	}else{
		$mmodify = Prev_registers::getIdenficationMenu($idmenu);
		if(!empty($mmodify)){
			$dataWay = Way::getListAllWay($_SESSION[Prev_registers::MMODIFY]); 
		}
	}

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['1']['status']='active';
	$stepsmenu['0']['href']='#';

	$page->setTpl('definir-caminho',array(
		'way'=>$dataWay,
		'mmodify' => $mmodify,
		'listAllOptions'=> ConfigureMenu::listAllOptions(),
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu)

	));
});

$app->post('/admin/:idmenu/created-way', function($idmenu) {
	User::verifyLogin();
	$page = new PageAdmin();
 	$way = new Way();
	if(isset($_POST) && !empty($_POST)){
		$way->SetWayAlternatives($_POST);
	}
	Way::movelocationUser("/{$id}/way");
	exit();
});

$app->post('/admin/:idmenu/duplicate',function($idmenu){
	User::verifyLogin();
	$way = new Way(); 
	// $way->getNotDuplicate($idmenu , $_POST);
	$data = $way->getDuplicate((int)$_SESSION[Way::IDENTIFYWAY]);	
	Way::formatDuplicidade($data,$_POST);
	
	Way::movelocationUser("/{$idmenu}/way");
		//header("Location: /admin/{$id}/way");
	exit();
});

$app->get('/admin/relatorio/claro/:idmenu/way', function($idmenu){

	$page = new PageAdmin();
	User::verifyLogin();
	$prevregisters = '';
	$mmodify = 0;
	$getListAllWay= '' ; 
	Prev_registers::getIdenficationMenu($idmenu);
	if(isset($idmenu) && !empty($idmenu)){
		$mmodify = Prev_registers::getIdenficationMenu($idmenu);
		if(!empty($mmodify)){
				$getListAllWay = Way::listAllWay();
			 $prevregisters= Prev_registers::getMModifySession();
			 $prevregisters['datePrev'] =  date("d/n/y - G:i ", strtotime($prevregisters['datePrev']))  ;

		}
	}
	
 	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['4']['status']='active';
	$stepsmenu['0']['href']='#';


	$page->setTpl('detalhes-caminho',array(
		'listAllOptions'=> ConfigureMenu::listAllOptions() ,	
		'prevregisters' => $prevregisters  ,
		'getListAllWay'=>$getListAllWay,
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu),
		'mmodify'=>$mmodify['0']['id_register']
	));
});


$app->get("/admin/way/edit/:id_way",function($id_way){
	User::verifyLogin();
	$page = new PageAdmin();
	
	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['1']['status']='active';
	$stepsmenu['0']['href']='#';
	$dataway = '' ; 
	
	if(isset($id_way) && !empty($id_way)){
		$dataway = Way::getway($id_way , true); 
		if(!count($dataway)>0){
			Information::setError_record('Não encontrado o Local de guarda'); 
		}	
	}else{
		Information::setError_record('Não Encontrado o identificador');
	}
	
	$page->setTpl("alterar-element",array(
		'stepsmenu'=>Prev_registers::formatStepsMenu($stepsmenu),
		"title"=>"Alterar o Local de Guarda",
		"layout"=>"alt-way",
		"dataway"=>$dataway

	));
});
$app->post("/admin/way/edit/:id_way",function($id_way){

	User::verifyLogin();
	if(isset($id_way) && !empty($id_way)){
		$dataway = Way::getway((int)$id_way , true); 
		if(count($dataway)>0){
			Way::updateWay($dataway,$_POST);
			 Way::movelocationUser("/{$dataway['0']['id_register']}/way");	
		}else{
			Information::setError_record('Não encontrado o Menus p/ alteração '); 
		}	
	}else{
		Information::setError_record('Não Encontrado o identificador');
		
	}

});

