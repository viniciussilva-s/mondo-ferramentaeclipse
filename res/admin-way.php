<?php 
use \vCode\PageAdmin;
use \vCode\Model\User;
use \vCode\Model\Prev_registers;
use \vCode\Model\Way;
use \vCode\Model\ConfigureMenu;
use \vCode\Model\Links;
use \vCode\Model\Seconds;


// /desv/desenUserLogin/index.php/admin/way/relatorio
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
	$configureLayout = [
		'text'=> 'Criar',
		'href'=> 'claro-create'
	];
	unset($_SESSION['IDENTIFYWAY']);
	unset($_SESSION['IDENTIFYLINK']);
	unset($_SESSION['MMODIFY']);

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['0']['status']='active';

	$page = new PageAdmin();  
	$page->setTpl('definir-nova-regra',array(
		'configureLayout'=>$configureLayout,
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu)
	));
});
// id_menu 
$app->get('/admin/val/relatorio/claro/:idmenu/way', function($idmenu) 
{

print_r($id_menu);
	User::verifyLogin();
	$page = new PageAdmin();
   $dataWay = '';
   $dataLinks = '';
   $dataSeconds = '';
   $mmodify = 0;
	Prev_registers::getIdenficationMenu($id_menu);
	if(isset($id_menu) && !empty($id_menu)){
		$mmodify = Prev_registers::getIdenficationMenu($id_menu);
		if(!empty($mmodify)){
			$dataWay = Way::getListAllWay($_SESSION[Prev_registers::MMODIFY]); 
			$dataLinks = Links::getListAll_LinksMmodific($_SESSION[Prev_registers::MMODIFY]); 
			$dataSeconds = Seconds::getListAll_PageSecondsMmodific($_SESSION[Prev_registers::MMODIFY]); 
		}
	}

	$stepsmenu = Prev_registers::dataStepsMenu();
	$stepsmenu['4']['status']='active';
	$stepsmenu['0']['href']='#';

	$page->setTpl('detalhes-caminho',array(
		'listAllOptions'=> ConfigureMenu::listAllOptions() ,	
		'way'=>$dataWay,
		'dataLinks'=>$dataLinks,
		'datasecondspages'=>$dataSeconds,
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

	$page->setTpl('detalhes-caminho',array(
		'listAllOptions'=> ConfigureMenu::listAllOptions() ,	
		'way'=>Way::getListAllWay(),
		'dataLinks'=>Links::getListAll_LinksMmodific(),
		'datasecondspages'=>Seconds::getListAll_PageSecondsMmodific(),
		'stepsmenu'=> Prev_registers::formatStepsMenu($stepsmenu)
	));
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
	$way = new Way() ; 
	$data = $way->getDuplicate((int)$_SESSION[Way::IDENTIFYWAY]);
	
	Way::formatDuplicidade($data,$_POST);
	$id = (int)$_SESSION[Way::IDENTIFYWAY];

	Way::movelocationUser("/{$id}/way");
		//header("Location: /admin/{$id}/way");
	exit();
});


