<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;
use \vCode\Model\Prev_registers;
use \vCode\Model\Logs;
use \vCode\Model\Information;
use \vCode\Model\Seconds;
use \vCode\Model\Links;

class Way extends Model
{

	const IDENTIFYWAY = "IDENTIFYWAY";
	public function __construct ($id_way = '')
	{

		if(Prev_registers::verifyPrev_registers()){
			if(!empty($id_way)){
				$_SESSION[Way::IDENTIFYWAY] = (int)$id_way;
			}else{
				$_SESSION[Way::IDENTIFYWAY] = Way::newIdentifyWay();
			}
		}
		
	}

	public static function newIdentifyWay()
	{
		$sql = new Sql();
		$rtl = $sql->select("
			SELECT way.id_way
			FROM way 
			INNER JOIN way_alternative AS wal
			ON way.id_way = wal.id_way
			WHERE way.id_register = :id_register
			ORDER by way.id_way DESC 
			LIMIT 1 
			",array(
				':id_register'=>$_SESSION[Prev_registers::MMODIFY]
			));
		if (count($rtl)>0) {
			if (isset($rtl['0']['id_way'])) {
				return  $rtl['0']['id_way'] ; 
			}
		}
	}
	public static function verifyWay()
	{

		if(!Way::checkWay()){
			// header('Location: /desv/desenUserLogin/index.php/admin/claro');
			if(Prev_registers::verifyPrev_registers()){
				Information::setError_record('É necessario a criação de um caminho antes de avançar para o próximo step');
				$id = $_SESSION[Prev_registers::MMODIFY]; 
				User::movelocationUser("/{$id}/way");
				exit;
			}else{
				Information::setError_record('Não encontra o menu de modificação');
				User::movelocationUser('/clarocreate');
				exit;
			}
		}else{
			return true ; 
		}
	}


	public static function checkWay()
	{
		if(isset($_SESSION[Way::IDENTIFYWAY])	|| !empty($_SESSION[Way::IDENTIFYWAY])){
			if((int)$_SESSION[Way::IDENTIFYWAY] > 0){
				return true ;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}


	public static function createdWay($name , $pageseconds)
	{
		$sql = new Sql(); 
		$rlt = $sql->query("INSERT INTO way (id_register,wayname , pageseconds) VALUES  (:id_register,:name , :pageseconds) ",array(
			":id_register"=> $_SESSION[Prev_registers::MMODIFY],  
			":pageseconds"=> $pageseconds,  
			":name"=> $name  
		));

		if($rlt > 0){

			$data = array();
			$data['action']=Logs::ACTIONS['Criação'];
			$data['area']='way';
			$data['id_item']=(int)$rlt;
			$data['old_value']='';
			$data['new_value']='created way';

			Logs::setUserlogs($data);

			return $rlt; 
		}
	}

	public function SetWayAlternatives($data)
	{
				
		if(Prev_registers::verifyPrev_registers()) {

			$id_way = Way::createdWay($data['name'],$data['pageseconds']);
			$sql = new Sql () ;
			$args = "";
			$values=array();
			foreach ($data as $key => $value) {
				if($key === 'pageseconds' ) {

				}
				if($dat= explode('id_alt',$key )){
					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
						$args .= "($id_way, :p$key ),";
					}	
				}
				if ($dat= explode('opts_alternatives',$key ) ){

					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
						$args .= "($id_way, :p$key ),";
					}	
				}
				
				else{
					//Caso for cadastrar algo diferente 
				}

			}


			//mandando para o bd alternativas e way 
			$args = rtrim($args, ",");
			$rtl =  $sql->query("INSERT INTO way_alternative(id_way, id_alt) VALUES $args"
				,$values
			);
			if(!empty($wayData = Way::getway($id_way))){
				$this->setData($wayData);
				$_SESSION[Way::IDENTIFYWAY] = (int)$id_way;

			}
			 //Save Way Userlogs 
			if(!empty($rtl)){
				Way::saveWayAlternativesLogs($id_way, $values );
			}
			if(isset($data['pageseconds'])=== true ){
				if($data['pageseconds'] === true or $data['pageseconds'] == 1 ){
				///:idmenu/way
				///admin/claro/way/:id_way/pageseconds
					Parent::movelocationUser("/claro/way/{$id_way}/pageseconds");
					exit();

				}else {
					Parent::movelocationUser("/way/claro/{$id_way}/links"); 
					exit();
				}

			}	 	

		}else {

			return false; 
		}

	}
	public static function getOneWay()
	{
		$sql = new Sql();
		$rtl = $sql->select("
			SELECT alt.name as name, way.id_way, wayname
			FROM way 
			INNER JOIN way_alternative AS wal
			ON way.id_way = wal.id_way 
			INNER JOIN opts_alternatives AS alt 
			ON wal.id_alt = alt.id_alt 
			INNER JOIN opts_registers as r 
			on alt.id_option = r.id_option
			WHERE way.id_way = :id_way
			ORDER BY r.id_option
			

			",array(
				'id_way'=>$_SESSION[Way::IDENTIFYWAY]
			));
		if(count($rtl)>0){
			return Way::formatDataTable($rtl) ;
		}else {

			Information::setError_record('Não encontrado o way');
		}
	}
	public static function getway($id_way , $notFormat = false )
	{
		if(!empty($id_way)){
			$sql = new Sql();
			$rtl = $sql->select("
				SELECT wayAlt.id_way,
				wayAlt.id_wayalternative,
				r.name as nameOption,
				alt.id_alt , 
				alt.name  as nameAlt,
				way.id_register,
				way.wayname,
				way.pageseconds 
				FROM way

				INNER JOIN way_alternative as wayAlt
				on way.id_way = wayAlt.id_way  

				INNER JOIN opts_alternatives as alt 	
				ON wayAlt.id_alt = alt.id_alt
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option
				WHERE way.id_way = :id_way
				ORDER BY r.id_option
				",array(
					":id_way"=>$id_way	
				));

			if(count($rtl)>0){
				$data = array();

				if ($notFormat) {
					return $rtl;
				}
				foreach ($rtl as $key => $value) {
					$data[$rtl[$key]['nameOption']] = $rtl[$key]['nameAlt'];
					$data['id_alt' . $rtl[$key]['id_alt']] = $rtl[$key]['id_alt'] ;
					$data['pageseconds'] = $rtl[$key]['pageseconds'];

				}

				return $data;
			}

		}else {
			Information::setError_record('Não encontrado o IDENTIFYWAY');
		}
	}
	

	// public function duplicateWay($way){

	// 	if(!empty($way)){
	// 		$data = array();													
	// 		foreach ((array)$way as $key => $value) {
	// 			if(explode("id_alt",$key)){
	// 				$data[$key] =  $value; 
	// 			}
	// 		}
	// 	}



	// 	$duplicateWay = new Way();	
	// 	$duplicateWay->SetWayAlternatives($data);
	// }

	public static function saveWayAlternativesLogs($id_way, $values)
	{

		foreach ($values as $key => $value) {
			$data = array();
			$data['action']=Logs::ACTIONS['Criação'];
			$data['area']='way_alternative';
			$data['id_item']=(int)$id_way;
			$data['old_value']='';
			$data['new_value']=$value;

			Logs::setUserlogs($data);

		}

	}
	public static function getListAllWay($id_register ='')
	{
		if(Prev_registers::verifyPrev_registers()){
			if(empty($id_register)){
				$id_register = 	$_SESSION[Prev_registers::MMODIFY];		
			}
			$sql = new Sql();
			$rlt = $sql->select("
				SELECT way.id_way, alt.name , wayname
				FROM way_alternative AS wayAlt 
				INNER JOIN way 
				ON wayAlt.id_way = way.id_way 
				INNER JOIN opts_alternatives as alt 
				on alt.id_alt = wayAlt.id_alt 
				INNER JOIN opts_registers as r 
				on r.id_option = alt.id_option 
				WHERE way.id_register = :id_register
				ORDER BY r.id_option ASC 
				",array(
					':id_register'=> $id_register 
				));


			if(count($rlt)>0){
				return Way::formatDataTable($rlt);
			}
		}else{
			return false;
		}

	}

	public static function formatDataTable($data = array())
	{
		
		$newdata = array();
		foreach ($data as $key => $value) {
			if (array_key_exists($data[$key]['id_way'],$newdata)) {

				array_push($newdata[$data[$key]['id_way']]['val'], array('name' => (string) $value['name'] ));
			} else {
				$newdata[$data[$key]['id_way']]=array(); 
				$newdata[$data[$key]['id_way']]['id_way'] = $data[$key]['id_way']; 
				$newdata[$data[$key]['id_way']]['name'] = $data[$key]['wayname']; 
				
				$newdata[$data[$key]['id_way']]['val']['0']['name'] = $data[$key]['name']; 
				// $newdata[$data[$key]['id_way']]['0'] = $data[$key]['name']; 
			}		

		}
		sort($newdata);
		return $newdata;
	}

	public function getDuplicate($id_way) {
		$sql = new Sql();
		$rlt= 	$sql->select("
			SELECT wayAlt.id_way,
			r.name as nameOption,
			alt.id_alt, 
			alt.name as nameAlt, 
			way.pageseconds 
			FROM way
			INNER JOIN way_alternative as wayAlt
			on way.id_way = wayAlt.id_way       
			INNER JOIN opts_alternatives as alt 	
			ON wayAlt.id_alt = alt.id_alt
			INNER JOIN opts_registers as r 
			on alt.id_option = r.id_option
			WHERE way.id_way = :id_way  and 
			r.id_option!= 1 and 
			r.id_option!= 2 and 
			r.id_option!= 3  

			ORDER BY r.id_option ASC
			",array(
				'id_way'=>$id_way
			));
		if (count($rlt)>0) {
			return $rlt;
		}
	}

	public static function listAllWay()
	{
		$dataWay = Way::getListAllWay(); 
		$dataSeconds = Seconds::getListAll_PageSecondsMmodific((int)$_SESSION[Prev_registers::MMODIFY]); 
		$dataLinks = Links::getListAll_LinksMmodific((int)$_SESSION[Prev_registers::MMODIFY]);  
		
		$ndata = array();
		foreach ($dataWay as $key => $value) 
		{
			if(count($dataSeconds)>0)
			{
				foreach ($dataSeconds as $key2 => $value2) 
				{
					if ((string)$dataWay[$key]['id_way'] == (string)$dataSeconds[$key2]['id_way']) 
					{		
						$dataWay[$key]['pageseconds'][ $dataSeconds[$key2]['id_sec']] =array();
						array_push($dataWay[$key]['pageseconds'][ $dataSeconds[$key2]['id_sec'] ], $dataSeconds[$key2]);
					}
				}
			}	
			if(count($dataLinks)>0)
			{
				foreach ($dataLinks as $key2 => $value2) 
				{
					if ((string)$dataWay[$key]['id_way'] == (string)$dataLinks[$key2]['id_way']) {
						$dataWay[$key]['links'][ $dataLinks[$key2]['id_link'] ] =array();
							array_push($dataWay[$key]['links'][ $dataLinks[$key2]['id_link'] ], $dataLinks[$key2]);
					}

				}
			}			

		}
		return $dataWay;

	}
	// public function getNotDuplicate($id_register , $dataRecebido) {
	// 	$sql = new Sql();
	// 	$rlt= 	$sql->select("
	// 		SELECT wayAlt.id_way,
	// 		r.name as nameOption,
	// 		alt.id_alt , 
	// 		alt.name  as nameAlt, 
	// 		way.pageseconds 
	// 		FROM way
	// 		INNER JOIN way_alternative as wayAlt
	// 		on way.id_way = wayAlt.id_way       
	// 		INNER JOIN opts_alternatives as alt 	
	// 		ON wayAlt.id_alt = alt.id_alt
	// 		INNER JOIN opts_registers as r 
	// 		on alt.id_option = r.id_option
	// 		WHERE way.id_register = :id_register  
	// 		and alt.id_alt  IN (:opts_registers1, :opts_registers2 , :opts_registers3) 
	// 		ORDER BY r.id_option ASC
	// 		",array(
	// 			':id_register'=>$id_register,
	// 			':opts_registers1'=>(int) $dataRecebido['opts_alternatives1'],
	// 			':opts_registers2'=>(int)$dataRecebido['opts_alternatives2'],
	// 			':opts_registers3'=>(int)$dataRecebido['opts_alternatives3']
	// 		));
	// 	if (count($rlt)>0) {
	// 		return Way::formatNotDuplicidade($rlt);
	// 	}
	// }
	// public static function formatNotDuplicidade($data = array())
	// {
	// 	$ndata = array();
	// 	foreach ($data as $key => $value) {

	// 		if(array_key_exists($data[$key]['id_way'], $ndata)){
	// 			array_push($ndata[$data[$key]['id_way']]['val'], array('nameAlt' => $data[$key]['nameAlt'])); 	
	// 		}else{
	// 			$ndata[$data[$key]['id_way']] = array();
	// 			$ndata[$data[$key]['id_way']]['val']['0']['nameAlt'] = $data[$key]['nameAlt'];
	// 		}
	// 		if ( count($ndata[$data[$key]['id_way']]['val']) == 2 ){
	// 			Information::setError_record('Diplicidade');
	// 			header('Location: http://catalogoclaro.comercial.ws/mondo/index.php/admin/24/way');
	// 			exit();
	// 		}

	// 	}
	// 	return $ndata ;

	// }
		public static function formatDuplicidade($data =array(),$datarec= array())
		{
			$i= 1 ;
			$ndata = array();

			foreach ($data as $key => $value) {
				if(isset($data[$key]['id_alt'])){
					$ndata['id_alt'.$data[$key]['id_alt'] ] = $data[$key]['id_alt'];   				   	 		
				}
			}
			foreach ($datarec as $key => $value) {
				if($dt= explode('opts_alternatives',$key )) {
					if(isset($dt['1']) ){
						$ndata['id_alt'.$value] = $value;
					}				
				}
			}
			
			$ndata['name']=$datarec['name'];
			$ndata['pageseconds'] = $datarec['pageseconds'];

			$duplicateWay = new Way();	
			$duplicateWay->SetWayAlternatives($ndata);
		}
		public static function getlistAllWayCreated($search = '' )
		{
			$sql = new Sql();
			if (isset($search) && !empty($search)) {
				$rtl = $sql->select("
					SELECT way.id_way, way.wayname,alt.name , way.id_register , way.created
					FROM way
					INNER JOIN way_alternative AS wAlt
					ON way.id_way = wAlt.id_way 
					INNER JOIN opts_alternatives as alt 
					ON wAlt.id_alt = alt.id_alt
					INNER JOIN opts_registers as r 
					on r.id_option = alt.id_option 
					where  way.wayname LIKE :wayname				
					ORDER BY r.id_option 

					", array(
						":wayname"=> "%". $search ."%"
					));	

			}else{

				$rtl = $sql->select("
					SELECT way.id_way, way.wayname,alt.name , way.id_register , way.created
					FROM way
					INNER JOIN way_alternative AS wAlt
					ON way.id_way = wAlt.id_way 
					INNER JOIN opts_alternatives as alt 
					ON wAlt.id_alt = alt.id_alt
					INNER JOIN opts_registers as r 
					on r.id_option = alt.id_option 
					ORDER BY r.id_option 
					");

			}
			if (count($rtl) > 0 ) {
				return Way::formtgeneralWay($rtl);
			}
		}
		public static function formtgeneralWay($data='')
		{
			$ndata= array();
			foreach ($data as $key => $value) {

				if(array_key_exists($data[$key]['id_way'],$ndata  )){


					array_push($ndata[$data[$key]['id_way']]['val'], array('name' => $data[$key]['name'])); 	

				}else{

					$ndata[$data[$key]['id_way']] = array(); 
						//numero de id_way
					$ndata[$data[$key]['id_way']]['id_way'] = $data[$key]['id_way']; 
					$ndata[$data[$key]['id_way']]['wayname'] = $data[$key]['wayname']; 
					$ndata[$data[$key]['id_way']]['id_register'] = $data[$key]['id_register']; 
					$ndata[$data[$key]['id_way']]['created'] = $data[$key]['created']; 
					$ndata[$data[$key]['id_way']]['val']['0']['name'] = $data[$key]['name']; 

				}				

			}
			sort($ndata);

			return $ndata ;

		}
		public static function getMenuAlternativesWay($wayData= array())
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
						return Way::formatMenuAlternativesWay($data , $wayData);
					}else {
						Information::setError_record('Erro ao pegar os dados');		
					}
				}else{
					Information::setError_record('Não encontrado a tabela de menu');		
					return false; 
				}
			}	
		}
	public static function formatMenuAlternativesWay($data , $wayData)
	{
		$string = ''; 	
		$idcolum = 0 ;
		$countRowElement = 0 ; 
		foreach ($data as $key => $value) {
			$countRowElement++; 
			 $id_option = "opts_alternatives{$wayData[$idcolum]['id_wayalternative']}" ;
			
			if($countRowElement == 1 ){
				$string .="<div class='row pt-4'>";	
			}else if($countRowElement  == 4 ){
				$string .="<div class='row pt-5'>";
			}


			$string .="<div class='col'><div class='input-block'>";
			$string .= "<label for='$id_option' class='input-block__label'>{$value['opt']} </label> ";

			$string .="<div class='input-block__cont'>";
			$string .=       "<select id='$id_option' name='$id_option' class='input-block__select-input'  >";

			foreach ($value as $key2 => $value2) {
				if (isset($value2['opt_alt'])) {
					if($value2['id_alt'] == $wayData[$idcolum]['id_alt']) {
						$string .="<option value={$value2['id_alt']} selected='true' >{$value2['opt_alt']} </option>";
						$idcolum ++ ; 
					}else{
						$string .="<option value={$value2['id_alt']} >{$value2['opt_alt']} </option>";
					}
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
	public static function updateWay( $wayData = array() , $dataPost = array())
	{	
		
		if(isset($wayData) && !empty($wayData) ){
				$id_way = $wayData['0']['id_way']; 
				$waynameAtual = $wayData['0']['wayname']; 
				$id_register = $wayData['0']['id_register'];
			
			$sql = new Sql(); 

			if(isset($dataPost['wayname']) && !empty($dataPost['wayname'])){
				if($dataPost['wayname'] != $waynameAtual ){
					$sql->query("
					UPDATE way SET wayname = :wayname where id_way = :id_way 
				",array(
					":wayname"=>$dataPost['wayname'],
					":id_way"=>(int)$id_way
				));
				$data = array();
				$data['action']= Logs::ACTIONS['Alteração'] ;
				$data ['area']= "way";
				$data['id_item']= (int)$id_way;
				$data['old_value']= $waynameAtual;
				$data['new_value']=$dataPost['wayname'] ;
				Logs::setUserlogs($data); 

				}
				
			}
				
			foreach ($dataPost as $key => $value) {
				if($dat= explode('opts_alternatives',$key )){
					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
				$args .= "UPDATE way_alternative SET id_alt = :p{$key} where id_way = {$id_way} and id_wayalternative = {$dat['1']};";
					}	
				}
			}	
			rtrim($args, ";");
			$sql->query($args,$values);
					
			Way::saveAlteracoesLink($wayData,$values);


			$dataatualizadoWay = Way::getThreeForWay($id_way);
			
			Way::alterWayBrothers($dataatualizadoWay , $wayData); 
			Way::alterWaychildrensLinks($dataatualizadoWay , $wayData['0']['id_register']);
		}else{
			Information::setError_record("Não encontrado dados do local de guarda para alteração");
		}
	}
	public static function saveAlteracoesLink($wayData = array(), $newdata = array() ){
		foreach ($wayData as $key => $value) {
			
			$data = array();
			$data['action']= Logs::ACTIONS['Alteração'] ;
			$data ['area']= "way_alternative";
			$data['id_item']= (int)$wayData[$key]['id_way'];
			$data['old_value']= $wayData[$key]['id_alt'];
			$data['new_value']= $newdata[':popts_alternatives' . $wayData[$key]['id_wayalternative']];

			Logs::setUserlogs($data); 		 
			
		}

	}
	public static function alterWayBrothers($dataatualizadoWay= array(), $wayData = array())
	{

		if(isset($wayData) && !empty($wayData) ){

			$sql = new Sql(); 
			$rlt = $sql->select("
				SELECT walt.id_wayalternative,
				walt.id_alt,
				way.id_way,
				r.id_option
				FROM  way 
				INNER JOIN way_alternative as walt
				on way.id_way = walt.id_way 
				inner join opts_alternatives as alt 
				on walt.id_alt = alt.id_alt 
				inner join opts_registers as r 
				on alt.id_option = r.id_option 
				where 
				way.id_register = :id_register and
				way.id_way != :id_way and
				r.id_option != 1 and
				r.id_option != 2 and
				r.id_option != 3
				order by r.id_option	
			",array(
				":id_register" => (int)$wayData['0']['id_register'] ,
				":id_way" => (int)$wayData['0']['id_way']
			));
			if(count($rlt)>0){
				$ndata = array(); 
				foreach ($rlt as $key => $value) {
					if(array_key_exists($rlt[$key]['id_option'], $ndata)){
						array_push($ndata[$rlt[$key]['id_option']], array(
							'id_way'=>$rlt[$key]['id_way'],
							'id_wayalternative'=>$rlt[$key]['id_wayalternative'],
							'id_alt'=>$rlt[$key]['id_alt']
						));
						
					}else{
						$ndata[$rlt[$key]['id_option']] = array();
						$ndata[$rlt[$key]['id_option']]['0']['id_way'] = $rlt[$key]['id_way'];
						$ndata[$rlt[$key]['id_option']]['0']['id_wayalternative'] = $rlt[$key]['id_wayalternative'];
						$ndata[$rlt[$key]['id_option']]['0']['id_alt'] = $rlt[$key]['id_alt'];
					}

				}
				$args = '';
				$values = array();
				if(!empty($ndata) && is_array($ndata)){

					foreach ($dataatualizadoWay as $key1 => $value) {
						foreach ($ndata[$dataatualizadoWay[$key1]['id_option']] as $key2 => $value){	
							
							$id_alt = ":id_alt".(string)$key1.(string)$key2 ;
							$id_wayalternative= ":id_wayalternative".(string)$key1.(string)$key2 ;
							$id_way= ":id_way".(string)$key1.(string)$key2 ;

							
			$values[$id_alt] =(int) $dataatualizadoWay[$key1]['id_alt']	;
			$values[$id_wayalternative] =(int) $ndata[$dataatualizadoWay[$key1]['id_option']][$key2]['id_wayalternative']	;
			$values[$id_way] =(int) $ndata[$dataatualizadoWay[$key1]['id_option']][$key2]['id_way']	;
							$args .= "UPDATE way_alternative SET 
							 id_alt = {$id_alt} WHERE id_wayalternative = {$id_wayalternative} and id_way = {$id_way};";
	 					}
						
					}		
				}
				$args = rtrim($args,";");
				$sql->query($args ,$values );





			}
			
		}
	}
	public static function alterWaychildrensLinks($dataatualizadoWay = '' , $id_register='')
	{
		
		if(isset($dataatualizadoWay) && !empty($dataatualizadoWay) ){
			$sql = new Sql(); 
			$rlt = $sql->select("
				SELECT lalt.id_liks_alternatives, 
				lalt.id_alt,
				ls.id_link, 
				r.id_option
				FROM links as ls
				INNER JOIN liks_alternatives as lalt
				on ls.id_link = lalt.id_link 
				INNER JOIN way 
				ON ls.id_way = way.id_way
				INNER JOIN opts_alternatives as alt 
				ON lalt.id_alt = alt.id_alt
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option 
				
				WHERE r.id_option != 1 AND
				r.id_option != 2 AND
				r.id_option != 3 AND
				way.id_register = :id_register
				order by r.id_option	
			",array(
				":id_register" => $id_register
			));
			if(count($rlt)>0){
				$ndata = array(); 
				foreach ($rlt as $key => $value) {
					if(array_key_exists($rlt[$key]['id_option'], $ndata)){
						array_push($ndata[$rlt[$key]['id_option']], array(
							'id_link'=>$rlt[$key]['id_link'],
							'id_liks_alternatives'=>$rlt[$key]['id_liks_alternatives'],
							'id_alt'=>$rlt[$key]['id_alt']
						));
						
					}else{
						$ndata[$rlt[$key]['id_option']] = array();
						$ndata[$rlt[$key]['id_option']]['0']['id_link'] = $rlt[$key]['id_link'];
						$ndata[$rlt[$key]['id_option']]['0']['id_liks_alternatives'] = $rlt[$key]['id_liks_alternatives'];
						$ndata[$rlt[$key]['id_option']]['0']['id_alt'] = $rlt[$key]['id_alt'];
					}

				}
				$args = '';
				$values = array();
				if(!empty($ndata) && is_array($ndata)){

					foreach ($dataatualizadoWay as $key1 => $value) {
						foreach ($ndata[$dataatualizadoWay[$key1]['id_option']] as $key2 => $value){	
							
							$id_alt = ":id_alt".(string)$key1.(string)$key2 ;
							$id_liks_alternatives= ":id_liks_alternatives".(string)$key1.(string)$key2 ;
							$id_link= ":id_link".(string)$key1.(string)$key2 ;

							
			$values[$id_alt] =(int) $dataatualizadoWay[$key1]['id_alt']	;
			$values[$id_liks_alternatives] =(int) $ndata[$dataatualizadoWay[$key1]['id_option']][$key2]['id_liks_alternatives']	;
			$values[$id_link] =(int) $ndata[$dataatualizadoWay[$key1]['id_option']][$key2]['id_link']	;
							$args .= "UPDATE liks_alternatives SET 
							 id_alt = {$id_alt} WHERE id_liks_alternatives = {$id_liks_alternatives} and id_link = {$id_link};";
	 					}
						
					}		
				}
				$args = rtrim($args,";");
				$sql->query($args ,$values );	
			}
		}
	}
	public static function getThreeForWay($id_way) 
	{
		if(isset($id_way) && !empty($id_way)){
	
		$sql = new Sql();
		$rlt= 	$sql->select("
		SELECT r.id_option, walt.id_alt
		FROM way 
		INNER JOIN way_alternative as walt 
		on way.id_way = walt.id_way
		INNER JOIN opts_alternatives as alt 
		on walt.id_alt = alt.id_alt 
		INNER JOIN opts_registers as r 
		on alt.id_option = r.id_option
		WHERE way.id_way= :id_way AND
		r.id_option !=1 AND
		r.id_option !=2 AND
		r.id_option !=3 
		ORDER BY r.id_option
			",array(
				':id_way'=>(int)$id_way
			));
		if (count($rlt)>0) {
			return $rlt;
		}
		}else{
			Information::setError_record("Não localizado o identificador de alteração");
		}
	}
		public static function deletWay($id_way = '')
		{
			$sql = new Sql();
			 $sql->query("DELETE FROM way WHERE id_way = :id_way",
			array("id_way"=> $id_way));
	
			$data = array();
				$data['action']=Logs::ACTIONS['Exclusão'];
				$data['area']='way and way_alternatives';
				$data['id_item']=(int)$id_way;
				$data['old_value']=$id_way;
				$data['new_value']='';
	
				Logs::setUserlogs($data);
			
			return true ; 
		}





	}
