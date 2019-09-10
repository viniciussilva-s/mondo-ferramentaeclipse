<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;
use \vCode\Model\Prev_registers;
use \vCode\Model\Way;
use \vCode\Model\Logs;

/**
 * 
 */
class Seconds extends Model
{
	const IDENTIFYSECONDS = 'IDENTIFYSECONDS';

	public function __construct()
	{
		if(Way::verifyWay()){
			$_SESSION[Seconds::IDENTIFYSECONDS] = Seconds::newIdentifySeconds();		

		}
	}
	public static function newIdentifySeconds()
	{
		if(!Way::verifyWay()){
			return false;
		}else{
			$sql = new Sql(); 
			$rtl = $sql->select("
				SELECT secp.id_sec
				FROM secpages AS secp 
				INNER JOIN secpages_alternatives as secAlt 
				ON secp.id_sec = secAlt.id_sec
				INNER JOIN way 
				ON secp.id_way = way.id_way
				WHERE secp.id_way = :id_way
				ORDER BY secp.id_sec DESC 
				LIMIT 1 
				",
				array(
					':id_way' => (int)$_SESSION[Way::IDENTIFYWAY]
				));

			if (count($rtl)>0) {
				if (isset($rtl['0']['id_sec'])) {
					return  $rtl['0']['id_sec'] ; 
				}
			}else{
				Information::setError_record('Falha ao carregar secpages');	
			}
		}
	}
	public static function createdSecondsPage( $nameSecondPage='' , $id_way='' )
	{

		if(Way::verifyWay() ){
			if(empty($id_way)){
				$id_way= $_SESSION[Way::IDENTIFYWAY];
			}
			$sql = new Sql(); 
			$rlt = $sql->query("INSERT INTO secpages(id_way,name_sec) VALUES (:id_way,:name_sec) ",array(
				":id_way"=> (int)$id_way,
				":name_sec" => $nameSecondPage 
			));

			if($rlt > 0){

				$data = array();
				$data['action']=Logs::ACTIONS['Criação'];
				$data['area']='secpages';
				$data['id_item']=(int)$rlt;
				$data['old_value']='';
				$data['new_value']='created seconds page';

				Logs::setUserlogs($data);

				return $rlt; 
			}else{

				return false;

			}
		}
	}

	public function getDuplicate($id_sec) {
		$sql = new Sql();
		$rlt= 	$sql->select("
			SELECT secp.id_sec , 
			r.name as nameOption,
			alt.id_alt,
			alt.name as nameAlt
			FROM secpages AS secp
			INNER JOIN secpages_alternatives as secAlt 
			ON secp.id_sec = secAlt.id_sec
			INNER JOIN opts_alternatives AS alt 
			on secAlt.id_alt = alt.id_alt 
			INNER JOIN opts_registers as r 
			on alt.id_option = r.id_option 
			WHERE secp.id_sec = :id_sec and r.id_option !=1 and r.id_option != 2 and r.id_option != 3
			ORDER by r.id_option

			",array(
				':id_sec'=>(int)$_SESSION[Seconds::IDENTIFYSECONDS]
			));
		if (count($rlt)>0) {
			return $rlt;
		}
	}
	public function formatDuplicidade($data =array(),$datarec= array())
	{
		$ndata = array();
		foreach ($data as $key => $value) {
			if(isset($data[$key]['id_alt'])){

				$ndata['id_alt'.$data[$key]['id_alt'] ] = $data[$key]['id_alt'];   				   	 		
			}
		}foreach ($datarec as $key => $value) {
			if($dt= explode('opts_alternatives',$key )) {
				if(isset($dt['1']) ){
					$ndata['id_alt'.$value] = $value;
				}				
			}
		}
		$ndata['name'] = $datarec['name'];

		$this->setSecondsAlternatives( $ndata);
	}


	public static function setSecondsAlternatives($data,$id_way = '')
	{
		if(Way::verifyWay()) {
			$id_sec = Seconds::createdSecondsPage($data['name'] ,$id_way );
			$sql = new Sql () ;
			$args = "";
			$values=array();
			foreach ($data as $key => $value) {

				if($dat= explode('id_alt',$key )){
					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
						$args .= "($id_sec, :p$key ),";
					}	
				}
				if ($dat= explode('opts_alternatives',$key ) ){

					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
						$args .= "($id_sec, :p$key ),";
					}	
				}
				else{
					//Caso for cadastrar algo diferente 
				}

			}
			//mandando para o bd alternativas e way 
			$args = rtrim($args, ",");
			$rtl =  $sql->query("INSERT INTO secpages_alternatives(id_sec, id_alt) VALUES $args"
				,$values
			);
			if(!empty($secpagesData = Seconds::getSecondsPages($id_sec))){
				// $this->setData($secpagesData);
				$_SESSION[Seconds::IDENTIFYSECONDS] = (int)$id_sec;

			}
			
			 //Save Way Userlogs 
			if(!empty($rtl)){
				Seconds::saveSecondsPagesAlternativesLogs($id_sec, $values );
			}

			
		}else {
			return false; 
		}

	}
	public static function getSecondsPages($id_secpages , $notFormat=false)
	{
		$sql = new Sql(); 

		$rtl = $sql->select("
			SELECT sec.id_sec,
			sec.id_way, 
			sec.name_sec,
			secAlt.id_secpages_alternatives,
			r.name as nameOption, 
			alt.id_alt,
			alt.name as nameAlt
			FROM secpages as sec 
			INNER JOIN secpages_alternatives as secAlt
			ON sec.id_sec = secAlt.id_sec 
			INNER JOIN opts_alternatives AS alt
			on secAlt.id_alt = alt.id_alt 
			INNER JOIN opts_registers as r 
			on alt.id_option = r.id_option 
			WHERE  sec.id_sec = :id_secpages 
			ORDER BY r.id_option
			",array(
				':id_secpages'=>$id_secpages
			));


		if (count($rtl ) > 0 ) {

			$data = array();
			if ($notFormat) {
				return $rtl;
			}
			foreach ($rtl as $key => $value) {
				$data[$rtl[$key]['nameOption']] = $rtl[$key]['nameAlt'];
				$data['id_alt' . $rtl[$key]['id_alt']] = $rtl[$key]['id_alt'] ;
				
			}
			
			return $data;
		}
	}

	public static function saveSecondsPagesAlternativesLogs($id_sec, $values= array() )
	{

		foreach ($values as $key => $value) {
			$data = array();
			$data['action']=Logs::ACTIONS['Criação'];
			$data['area']='secpages_alternatives';
			$data['id_item']=(int)$id_sec;
			$data['old_value']='';
			$data['new_value']=$value;

			Logs::setUserlogs($data);

		}
	}
	public static function getListAll_secondspages($id_way='')
	{

		$newpage = new Way();
		if(Way::verifyWay()){
			if(empty($id_way)){
				$id_way = $_SESSION[Way::IDENTIFYWAY]; 
			}
			$sql = new Sql();
			$rlt = $sql->select("
				SELECT secp.id_sec, alt.name, secp.name_sec
				FROM secpages AS secp 
				INNER JOIN secpages_alternatives as secAlt 
				ON secp.id_sec = secAlt.id_sec
				INNER JOIN way 
				ON secp.id_way = way.id_way
				INNER JOIN opts_alternatives as alt 
				on secAlt.id_alt = alt.id_alt 
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option
				WHERE secp.id_way = :id_way
				ORDER BY r.id_option ASC 


				",array(
					':id_way'=> $id_way 
				));


			if(count($rlt)>0){
				return Seconds::formatDataTable($rlt);
			}
		}else{
			return false ;
		}

	}
	public static function getListAll_PageSecondsMmodific($id_mmodific ='')
	{
		$newpage = new Way();
		if(Way::verifyWay()){
			if(empty($id_mmodific)){
				$id_mmodific  = $_SESSION[Prev_registers::MMODIFY]; 
			}

			$sql = new Sql();
			$rlt = $sql->select("
				SELECT way.id_way , secp.id_sec, alt.name, secp.name_sec
				FROM secpages AS secp 
				INNER JOIN secpages_alternatives as secAlt 
				ON secp.id_sec = secAlt.id_sec
				INNER JOIN way 
				ON secp.id_way = way.id_way
				INNER JOIN opts_alternatives as alt 
				on secAlt.id_alt = alt.id_alt 
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option
				WHERE way.id_register = :id_mmodific
				ORDER BY r.id_option ASC 

				",array(
					':id_mmodific'=> $id_mmodific  
				));


			if(count($rlt)>0){
			//return $rlt;
				return Seconds::formatDataTable($rlt);
			}
		}else{
			return false;
		}

	}
	public static function formatDataTable($data = array())
	{
		
		$newdata = array();
		foreach ($data as $key => $value) {
			if (array_key_exists($data[$key]['id_sec'],$newdata)) {

				array_push($newdata[$data[$key]['id_sec']]['val'], array('name' => (string) $value['name'] ));
			} else {
				$newdata[$data[$key]['id_sec']]=array(); 
				$newdata[$data[$key]['id_sec']]['id_sec'] = $data[$key]['id_sec']; 
				$newdata[$data[$key]['id_sec']]['id_way'] = $data[$key]['id_way']; 
				$newdata[$data[$key]['id_sec']]['name'] = $data[$key]['name_sec']; 
				
				$newdata[$data[$key]['id_sec']]['val']['0']['name'] = $data[$key]['name']; 
				// $newdata[$data[$key]['id_sec']]['0'] = $data[$key]['name']; 
			}		

		}
		sort($newdata);
		return $newdata;
	}
	public static function getMenuAlternativasAlterarPageSec($secpagesData= array())
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
					return Seconds::FormatMenuAlternativasAlterPageSec($data , $secpagesData);
				}else {
					Information::setError_record('Erro ao pegar os dados');		
				}
			}else{
				Information::setError_record('Não encontrado a tabela de menu');		
				return false; 
			}
		}	
	}
	public static function FormatMenuAlternativasAlterPageSec($data , $secpagesData)
	{
		$string = ''; 	
		$idcolum = 0 ;
		$countRowElement = 0 ; 
	
		foreach ($data as $key => $value) {
			$countRowElement++; 

			// $id_option = "opts_alternatives{$value['id_option']}" ;
			 $id_option = "opts_alternatives{$secpagesData[$idcolum]['id_secpages_alternatives']}" ;
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
					if($value2['id_alt'] == $secpagesData[$idcolum]['id_alt']) {
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
	public static function updateSecondsPage( $secpagesData ='' , $dataPost = array())
	{	
		
		if(isset($secpagesData) && !empty($secpagesData) ){
			$id_sec = $secpagesData['0']['id_sec']; 
			$name_secAtual = $secpagesData['0']['name_sec']; 
		}
	
		$sql = new Sql(); 

		if(isset($dataPost['name_sec']) && !empty($dataPost['name_sec'])){
			if($dataPost['name_sec'] != $name_secAtual ){
				$sql->query("
				UPDATE secpages SET name_sec = :name_sec where id_sec = :id_sec 
			",array(
				":name_sec"=>$dataPost['name_sec'],
				":id_sec"=>$id_sec
			));
			$data = array();
			$data['action']= Logs::ACTIONS['Alteração'] ;
			$data ['area']= "secpages";
			$data['id_item']= (int)$id_sec;
			$data['old_value']= $name_secAtual;
			$data['new_value']=$dataPost['name_sec'] ;
			Logs::setUserlogs($data); 

			}
			
		}
		foreach ($dataPost as $key => $value) {
			if($dat= explode('opts_alternatives',$key )){
				if(isset($dat['1'])){
					$values[":p" . $key] = (int)$value;
			$args .= "UPDATE secpages_alternatives SET id_alt = :p{$key} where id_sec = {$id_sec} and id_secpages_alternatives = {$dat['1']};";
				}	
			}
		}	
		rtrim($args, ";");
		$sql->query($args,$values);
				
		Seconds::saveAlteracoesLogsPageSeconds($secpagesData,$values);
	}
	public static function saveAlteracoesLogsPageSeconds($secpagesData = array(), $newdata = array() ){
		foreach ($secpagesData as $key => $value) {
			
			$data = array();
			$data['action']= Logs::ACTIONS['Alteração'] ;
			$data ['area']= "secpages_alternatives";
			$data['id_item']= (int)$secpagesData[$key]['id_sec'];
			$data['old_value']= $secpagesData[$key]['id_alt'];
			$data['new_value']= $newdata[':popts_alternatives' . $secpagesData[$key]['id_secpages_alternatives']];

			Logs::setUserlogs($data); 		 
			
		}

	}
	public static function deletSeconds($id_sec = '')
	{
		$sql = new Sql();
		 $sql->query("DELETE FROM secpages WHERE id_sec = :id_sec",
		array("id_sec"=> (int)$id_sec));

		$data = array();
			$data['action']=Logs::ACTIONS['Exclusão'];
			$data['area']='secpages and secpages_alternatives';
			$data['id_item']=(int)$id_sec;
			$data['old_value']=$id_sec;
			$data['new_value']='';

			Logs::setUserlogs($data);
		
		return true ; 
	}


}