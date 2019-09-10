<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;

class Prev_registers extends Model
{

	const MMODIFY = "MMODIFY";
	const CONFIGUREMENU = "CONFIGUREMENU";

	private $menuoptionsealternativas = '';
	private $data = [
		'action'=> Logs::ACTIONS['Criação'],
		'area' => ""  ,
		'id_item'=> 0,
		'old_value'=>'',
		'new_value' => '' 
	];
	
	public static function dataStepsMenu()
	{	
		$idmenu = isset($_SESSION[Prev_registers::MMODIFY])?$_SESSION[Prev_registers::MMODIFY]:0; 
		$stepsmenu=[
			['text'=> 'Cadastro','number'=>'1.','href'=> 'http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro-create','status'=>''],
			['text'=>'Definir local de guarda','number'=>'2.',  'href'=> "http://catalogoclaro.comercial.ws/mondo/index.php/admin/{$idmenu}/way",'status'=>''],
			['text'=>'Páginas Secundárias',	'number'=>'3.','href'=> 'http://catalogoclaro.comercial.ws/mondo/index.php/admin/way/pageseconds/none','status'=>''],
			['text'=>'Definir menus' ,'number'=>'4.', 'href'=>'http://catalogoclaro.comercial.ws/mondo/index.php/admin/way/none/links' ,'status'=>''],
			['text'=>'Gerar Relatório Final','number'=>'5.','href'=>'http://catalogoclaro.comercial.ws/mondo/index.php/admin/claro/way/relatorio' ,'status'=>'']			
		];
		return $stepsmenu;
		
	}

	public static function formatStepsMenu($stepsmenu){

		$string = '' ; 
		$string .= "<nav class='nav-steps py-4'><ul class='navbar-nav navbar-expand justify-content-around align-items-center'>";
		foreach ($stepsmenu as $key => $value) {

			$string .="<li class='nav-item flex-fill text-center {$stepsmenu[$key]['status']}'>";
			$string .="<a class='nav-link' href='{$stepsmenu[$key]['href']}'>";
			$string .="<span class='mr-1'>{$stepsmenu[$key]['number']}</span>{$stepsmenu[$key]['text']}</a></li>";
		}
		$string .="</ul></nav>";

		echo $string;
	}
	public static function verifyPrev_registers()
	{

		if(!Prev_registers::checkPrev_registers()){
			Information::setError_record('É necessario a criação de uma regra para continuar');
			Prev_registers::movelocationUser('/claro-create');
			exit();
		}else{
			return true ; 
		}
	}
	public static function checkPrev_registers()
	{
		if(
			isset($_SESSION[Prev_registers::MMODIFY])	||
			!empty($_SESSION[Prev_registers::MMODIFY]) 
		){
			if ($_SESSION[Prev_registers::MMODIFY] > 0 )  {
				return true ;
			}else{
				return false;	
			}
			
		}else{
			return false;
		}
	}

	public static function getIdenficationMenu($idprev_register ='')
	{
		if(empty($idprev_register)){
			Information::setError_record('Não Há indeficador de menu');
			User::movelocationUser('/claro-create');

		}else {

			$sql = new Sql();
			$rtl = $sql->select("SELECT * 
				FROM prev_registers as pv
				WHERE pv.keep_content = 1 
				and pv.id_register = :id_register ",array(
					':id_register'=>(int)$idprev_register
				)); 

			
			if(count($rtl)>0){
				$_SESSION[Prev_registers::MMODIFY] = (int)$rtl[0]['id_register']; 
				return $rtl; 
			}else{
				if(Prev_registers::checkExistsMenu($idprev_register)){
					$_SESSION[Prev_registers::MMODIFY] = Prev_registers::alterKeep_content($idprev_register); 
					return $idprev_register; 	
				}else{

					Information::setError_record('Menu atual não encontrado');
					User::movelocationUser('/claro-create');
				}
			}
		}
	}

	public static function  checkExistsMenu($idprev_register='')
	{
		$sql = new Sql();
		$rtl = $sql->select("SELECT * 
			FROM prev_registers as pv
			WHERE pv.keep_content = 0 
			and pv.id_register = :id_register ",array(

				':id_register'=>(int)$idprev_register
			));
		if(count($rtl) > 0){
			return true; 
		}else{
			return false;
		}
	}
	public static function alterKeep_content($id_register)
	{
		$sql = new Sql();
		$rtl = $sql->query("
			UPDATE prev_registers 
			SET keep_content = :keep_content  
			WHERE id_register = :id_register

			",array(
				":keep_content"=> 1 ,  
				":id_register"=> (int)$id_register 
			));

		return $id_register; 

	}
	public static function getMModifySession()
	{

		if (!Prev_registers::checkPrev_registers()) {
		  	// Não há menu na session 
			return false ;
		} else {
			$sql = new Sql();
			$rtl = $sql->select("SELECT * , pv.created as datePrev
				FROM prev_registers as pv
				INNER join users as u 
				on pv.id_user = u.id_user
				WHERE pv.keep_content = 1 
				and pv.id_register = :id_register ",array(
					':id_register'=>(int) $_SESSION[Prev_registers::MMODIFY]
				)); 
			if(count($rtl) > 0 ){
				return $rtl['0'];
			}

		}				
	}
	public static function listAll($search = '' , $keep_content=true)
	{
		$sql = new Sql() ; 
		if(isset($search) && !empty($search)){
			$rlt = $sql->select("
				SELECT prevR.id_register
				,prevR.original_menu
				,prevR.original_local
				,prevR.name 
				,prevR.description
				,prevR.created as datePrev
				,users.username as nameUser
				FROM prev_registers as prevR
				INNER join users 
				on prevR.id_user = users.id_user
				WHERE (
				prevR.original_menu LIKE :search
				OR prevR.original_local LIKE :search
				OR prevR.name LIKE :search )
				and prevR.keep_content = :keep_content
				ORDER by prevR.id_register ",
				array(
					':search' =>'%'. $search. '%', 
					':keep_content'=> (int)$keep_content
				)); 
		}else{
			$rlt = $sql->select("
				SELECT prevR.id_register
				,prevR.original_menu
				,prevR.original_local
				,prevR.name 
				,prevR.description
				,prevR.created as datePrev
				,u.username as nameUser
				FROM prev_registers as prevR
				INNER join users as u
				on prevR.id_user = u.id_user
				WHERE prevR.keep_content = :keep_content
				order by prevR.id_register
				",array(
					':keep_content'=>(int)$keep_content
				));
		}
		if (count($rlt)> 0 ){
			return $rlt;
		} else {
			// Information::setError_record('
			// 	Erro ao retornar dados. <br><i class="fa fa-arrow-right"></i> Entrar em contato com o suporte
			// 	'); 
			//System Error
			return false; 
		}
	}
	public function save()
	{
		
		$sql = new Sql () ;    			
		
		$rtl = $sql->query("
			INSERT INTO prev_registers
			(original_menu, original_local, name, keep_content, description,id_user) 
			VALUES (:original_menu, :original_local, :name, :keep_content, :description, :id_user)	
			",array(
				':original_menu'=>$this->getoriginal_menu(),
				':original_local'=>$this->getoriginal_local(), 
				':name'=>$this->getname(),
				':keep_content'=>$this->getkeep_content(),
				':description'=>$this->getdescription(),
				':id_user'=>(int)$_SESSION[User::SESSION]['id_user']
			));

		if(isset($rtl) && !empty($rtl)){
			$field_alt = [
				'original_menu'=>$this->getoriginal_menu(),
				'original_local'=>$this->getoriginal_local(), 
				'name'=>$this->getname(),
				'description'=>$this->getdescription(),
				':keep_content'=>$this->getkeep_content(),
			];
			foreach ($field_alt as $key => $value) {
				$this->data['id_item'] = $rtl ; 
				$this->data['area'] = "prev_registers - $key" ; 
				$this->data['new_value'] = $value; 

				//Information::setSuccess_record('prev_registers ');
				Logs::setUserlogs($this->data );
			}

			if(boolval($this->getkeep_content())){

				$_SESSION[Prev_registers::MMODIFY]= (int)$rtl;
				//Movendo para criação de caminho	
				User::movelocationUser("/{$rtl}/way");

			}else{

				User::movelocationUser('/claro/naomantidos');

			}	

			
		}else{
			Information::setError_record('Erro -prev_registers ');
		} 	
	}
	public function getMenuAlternatives()
	{

		if(!Prev_registers::verifyPrev_registers()){
			return false;
		}else {
			$sql = new Sql(); 

			$rtl = $sql->select("
				SELECT r.name as opt_name,
				r.id_option,
				alt.name as opt_alt,
				alt.id_alt
				FROM opts_registers as r 
				INNER JOIN opts_alternatives as alt 
				on r.id_option = alt.id_option
				WHERE alt.status_alternatives = 1 
				ORDER BY r.id_option ASC
				");	
			if(count($rtl)>0){
				$data = array();
				foreach ($rtl as $key => $value) {
					if(array_key_exists($value["opt_name"], $data)){
						array_push($data[$value["opt_name"]], array(
							"opt_alt"=>$value["opt_alt"],
							"id_alt" =>$value['id_alt']
						));
						///array_push($data[$value["opt_name"]], $da[$i]);
					}else
					{					
						$data[$value["opt_name"]] = array();
						$data[$value["opt_name"]]['opt'] = $value["opt_name"];
						$data[$value["opt_name"]]['id_option'] = $value["id_option"];
						array_push($data[$value["opt_name"]], array(
							"opt_alt"=>$value["opt_alt"],
							"id_alt" =>$value['id_alt']
						));
						//$data[$value["opt_name"]] = array($value["opt_alt"]);
					}
					
				}

				if(is_array($data)){
					return Prev_registers::FormatMenuAlternatives($data);
				}else {
					Information::setError_record('Erro ao pegar os dados');		
				}
			}else{
				Information::setError_record('Não encontrado a tabela de menu');		
				return false; 
			}
		}	
	}
	public static function FormatMenuAlternatives($data)
	{
		$string = ''; 	

		$countRowElement = 0 ; 
		foreach ($data as $key => $value) {
			$countRowElement++; 

			$id_option = "opts_alternatives{$value['id_option']}" ;
			if($countRowElement == 1 ){
				$string .="<div class='row pt-4'>";	
			}else if($countRowElement  == 4 ){
				$string .="<div class='row pt-5'>";
			}


			$string .="<div class='col'><div class='input-block'>";
			$string .= "<label for='$id_option' class='input-block__label'>{$value['opt']} </label> ";

			$string .="<div class='input-block__cont'>";
			$string .=       "<select id='$id_option' name='$id_option' class='input-block__select-input'  >";

			//$string .="<option selected='true'  disabled='disabled' > </option>";
			foreach ($value as $key2 => $value2) {

				if (isset($value2['opt_alt'])) {
					$string .="<option value={$value2['id_alt']} >{$value2['opt_alt']} </option>";
				}					

			}
			$string .=   "</select>";
			$string .=   "</div></div></div>";

			if($countRowElement == 3 ){
				$string .="</div>";	
			}else if($countRowElement == 6 ){
				$string .="</div>";
			}
		}
		if(!empty($string)){
			return $string; 
		}else {
			Information::setError_record('Erro na formação do menu');
			exit();
		}
	}
	public function getMenuAlternativesDisabled($way)
	{

		if(!Prev_registers::verifyPrev_registers()){
			return false;
		}else {

			$sql = new Sql(); 

			$rtl = $sql->select("
				SELECT r.name as opt_name,
				r.id_option,
				alt.name as opt_alt,
				alt.id_alt
				FROM opts_registers as r 
				INNER JOIN opts_alternatives as alt 
				on r.id_option = alt.id_option
				WHERE alt.status_alternatives = 1
				ORDER BY r.id_option ASC
				");	
			if(count($rtl)>0){
				$data = array();
				foreach ($rtl as $key => $value) {
					if(array_key_exists($value["opt_name"], $data)){
						array_push($data[$value["opt_name"]], array(
							"opt_alt"=>$value["opt_alt"],
							"id_alt" =>$value['id_alt']
						));
						///array_push($data[$value["opt_name"]], $da[$i]);
					}else
					{					
						$data[$value["opt_name"]] = array();
						$data[$value["opt_name"]]['opt'] = $value["opt_name"];
						$data[$value["opt_name"]]['id_option'] = $value["id_option"];
						array_push($data[$value["opt_name"]], array(
							"opt_alt"=>$value["opt_alt"],
							"id_alt" =>$value['id_alt']
						));
						//$data[$value["opt_name"]] = array($value["opt_alt"]);
					}
					
				}

				if(is_array($data)){
					return Prev_registers::FormatMenuAlternativesDisabled($data,$way);
				}else {
					Information::setError_record('Erro ao pegar os dados');		
				}
			}else{
				Information::setError_record('Não encontrado a tabela de menu');		
				return false; 
			}
		}	
	}
	public static function FormatMenuAlternativesDisabled($data , $way )
	{
		$string = ''; 	
		$tres = array_slice($data,0 ,3);
		$indice = 0 ;
		foreach ($way as $key => $value) {
			if ($indice ===0){
				$ultimos = array_slice($way[$key]['val'] ,3,7);
				$indice ++;
			}
			
		}

		// $ultimos = array_slice($way,4,count($way));

		$idcolumn = 0;
		$idultimos = 0;
		$countRowElement = 0;
		foreach ($data as $key => $value) {
			$countRowElement++; 

			$id_option = "opts_alternatives{$value['id_option']}" ;
			if($countRowElement == 1 ){
				$string .="<div class='row pt-4'>";	
			}else if($countRowElement  == 4 ){
				$string .="<div class='row pt-5'>";
			}

			$string .="<div class='col'>";
			$string .="<div class='input-block'>";
			$string .= "<label for='$id_option' class='input-block__label'>{$value['opt']} </label> ";
			$string .="<div class='input-block__cont'>";

			$indice = (string)$key; 
			$compare = isset($tres[$indice]['id_option'])?$tres[$indice]['id_option']:'';
			
			if ($data[$indice]['id_option'] == $compare){
				$string .=   "<select id='$id_option' name='$id_option' class='input-block__select-input'   >";
			// $string .="<option selected='true'  disabled='disabled' > </option>";
			}else{
				$string .=       "<select id='$id_option' name='$id_option' class='input-block__select-input'  disabled='disabled'>";

			}

			foreach ($value as $key2 => $value2) {
				if (isset($value2['opt_alt'])) {
					if($idcolumn > 2)
					{
						// $string .="<option value={$value2['id_alt']} selected='true'>{$value2['opt_alt']}</option>";
						 $string .="<option value={$value2['id_alt']}>{$ultimos[$idcolumn- 3]['name']} </option>";
					}else
					{
						$string .="<option value={$value2['id_alt']} > {$value2['opt_alt']} </option>";
					}

				}
				//$idcolumn++;				
			}
			$idcolumn++;				
			$string .=   "</select>";
			$string .=   "</div></div></div>";
			if($countRowElement == 3 ){
				$string .="</div>";	
			}else if($countRowElement == 6 ){
				$string .="</div>";
			}	
		}

		if(!empty($string)){
			return $string; 
		}else {
			Information::setError_record('Erro na formação do menu');
			exit();
		}
	}
	

}
?> 