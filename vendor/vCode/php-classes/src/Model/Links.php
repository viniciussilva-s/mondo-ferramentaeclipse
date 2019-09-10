<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;
use \vCode\Model\Prev_registers;
use \vCode\Model\Way;
use \vCode\Model\Logs;
use \vCode\Model\Information;

class Links extends Model
{
	const IDENTIFYLINK = 'IDENTIFYLINK';
	public function __construct($id_way = '')
	{
		if(Way::verifyWay()){
			$_SESSION[Links::IDENTIFYLINK] = Links::newIdentifyLink();
		}

	}
	public static function newIdentifyLink()
	{
		if(!Way::verifyWay()){
			return false;
		}else{
			$sql = new Sql(); 
			$rtl = $sql->select("
				SELECT links.id_link 
				FROM links 
				INNER JOIN liks_alternatives as alt 
				on links.id_link = alt.id_link
				WHERE links.id_way = :id_way 
				ORDER BY links.id_link DESC 
				LIMIT 1 
				",
				array(
					':id_way' => (int)$_SESSION[Way::IDENTIFYWAY]
				));

			if (count($rtl)>0) {
				if (isset($rtl['0']['id_link'])) {
					return  $rtl['0']['id_link'] ; 
				}
			}else{
				//Information::setError_record('Falha ao carregar o link pai');	
			}
		}
	}
	public static function createdLink($name='' ,$id_way = '')
	{

		if(Way::verifyWay() ){

			if(empty($id_way)){
				$id_way =$_SESSION[Way::IDENTIFYWAY] ;
			}
			$sql = new Sql(); 
			$rlt = $sql->query("INSERT INTO links(id_way,name) VALUES (:id_way,:name) ",array(
				":id_way"=> (int)$id_way, 
				":name"=> $name
			));

			if($rlt > 0){

				$data = array();
				$data['action']=Logs::ACTIONS['Criação'];
				$data['area']='links';
				$data['id_item']=(int)$rlt;
				$data['old_value']='';
				$data['new_value']='created link';

				Logs::setUserlogs($data);

				return $rlt; 
			}else{

				return false;

			}
		}
	}	
	public static function setLinksAlternativs($data ,$id_way = '')
	{

		if(Way::verifyWay()) {
			$id_link = Links::createdLink($data['name'] ,$id_way);

			$sql = new Sql () ;
			$args = "";
			$values=array();
			foreach ($data as $key => $value) {

				if($dat= explode('id_alt',$key )){
					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
						$args .= "($id_link, :p$key ),";
					}	
				}
				if ($dat= explode('opts_alternatives',$key ) ){

					if(isset($dat['1'])){
						$values[":p" . $key] = (int)$value;
						$args .= "($id_link, :p$key ),";
					}	
				}
				else{
					//Caso for cadastrar algo diferente 
				}

			}

					//mandando para o bd alternativas e way 
			$args = rtrim($args, ",");
			$rtl =  $sql->query("INSERT INTO liks_alternatives(id_link, id_alt) VALUES $args"
				,$values
			);
			if(!empty($linkData = Links::getLink($id_link))){
				//$this->setData($linkData);
				$_SESSION[Links::IDENTIFYLINK] = (int)$id_link;

			}
			 //Save Way Userlogs 
			if(!empty($rtl)){
				Links::saveLinkAlternativesLogs($id_link, $values );
			}


		}else {

			return false; 
		}


	}
	public static function getLink($id_link , $notFormat=false)
	{
		$sql = new Sql(); 

		$rtl = $sql->select("
			SELECT links.id_link,
			links.name as namelink, 
			links.id_way,
			linkAlt.id_liks_alternatives,
			r.name as nameOption,
			alt.id_alt,
			alt.name as nameAlt
			FROM links 
			INNER JOIN liks_alternatives as linkAlt 
			on links.id_link = linkAlt.id_link 
			INNER JOIN opts_alternatives as alt 
			on linkAlt.id_alt = alt.id_alt 
			INNER JOIN opts_registers as r 
			on alt.id_option  = r.id_option
			WHERE links.id_link =  :id_link
			ORDER BY r.id_option 
			",array(
				':id_link'=>$id_link
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

	public static function saveLinkAlternativesLogs($id_link, $values)
	{

		foreach ($values as $key => $value) {
			$data = array();
			$data['action']=Logs::ACTIONS['Criação'];
			$data['area']='liks_alternatives';
			$data['id_item']=(int)$id_link;
			$data['old_value']='';
			$data['new_value']=$value;

			Logs::setUserlogs($data);

		}

	}
	public static function getListAll_Links($id_way='')
	{
		$newpage = new Way();
		if(Way::verifyWay()){
			if(empty($id_way)){
				$id_way = $_SESSION[Way::IDENTIFYWAY]; 
			}

			$sql = new Sql();
			$rlt = $sql->select("
				SELECT links.id_link, alt.name , links.name as namelink 
				FROM way 
				INNER JOIN links 
				ON way.id_way = links.id_way 
				INNER JOIN liks_alternatives as linkAlt
				on links.id_link = linkAlt.id_link
				INNER JOIN opts_alternatives as alt 
				on linkAlt.id_alt = alt.id_alt
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option 
				WHERE way.id_way = :id_way
				ORDER by r.id_option ASC 

				",array(
					':id_way'=> $id_way 
				));


			if(count($rlt)>0){
			//return $rlt;
				return Links::formatDataTable($rlt);
			}
		}else{
			return false;
		}

	}
	public static function getListAll_LinksMmodific($id_mmodific ='')
	{
		$newpage = new Way();
		if(Way::verifyWay()){
			if(empty($id_mmodific )){
				$id_mmodific  = $_SESSION[Prev_registers::MMODIFY]; 
			}

			$sql = new Sql();
			$rlt = $sql->select("
				SELECT way.id_way , links.id_link, alt.name , links.name as namelink 
				FROM way 
				INNER JOIN links 
				ON way.id_way = links.id_way 
				INNER JOIN liks_alternatives as linkAlt
				on links.id_link = linkAlt.id_link
				INNER JOIN opts_alternatives as alt 
				on linkAlt.id_alt = alt.id_alt
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option 
				WHERE way.id_register =  :id_mmodific
				ORDER by r.id_option ASC 

				",array(
					':id_mmodific'=> (int)$id_mmodific  
				));


			if(count($rlt)>0){
			//return $rlt;
				return Links::formatDataTable($rlt);
			}
		}else{
			return false;
		}

	}

	

	public static function formatDataTable($data = array())
	{

		$newdata= array();
		foreach ($data as $key => $value) {
			if(isset($data[$key]['id_link'])){
				if (array_key_exists($data[$key]['id_link'],$newdata)) {
					array_push($newdata[$data[$key]['id_link']]['val'], array('name' => (string) $value['name'] ));
				// array_push($newdata[$data[$key]['id_link']], (string) $value['name']);
				} else {
					$newdata[$data[$key]['id_link']]=array(); 
					$newdata[$data[$key]['id_link']]['id_link'] = $data[$key]['id_link']; 
					$newdata[$data[$key]['id_link']]['namelink'] = $data[$key]['namelink']; 
					$newdata[$data[$key]['id_link']]['id_way'] = $data[$key]['id_way']; 


					$newdata[$data[$key]['id_link']]['val']['0']['name'] = $data[$key]['name']; 
				// $newdata[$data[$key]['id_link']]['0'] = $data[$key]['name']; 
				}
			}		

		}
		sort($newdata);
		return $newdata;
	}
	
	public function getDuplicate($id_link) {
		$sql = new Sql();
		$rlt= 	$sql->select("
			SELECT   links.id_link, 
			r.name as nameOption,
			alt.id_alt,
			alt.name as nameAlt
			FROM links 
			INNER JOIN liks_alternatives as lAlt 
			ON links.id_link = lAlt.id_link 
			INNER JOIN opts_alternatives as alt 
			on lAlt.id_alt = alt.id_alt 
			inner JOIN opts_registers as r 
			on alt.id_option = r.id_option 
			WHERE links.id_link = :id_link and r.id_option !=1 and r.id_option != 2 and r.id_option != 3
			ORDER BY r.id_option
			",array(
				':id_link'=>(int)$_SESSION[Links::IDENTIFYLINK]
			));
		if (count($rlt)>0) {
			return $rlt;
		}
	}
	public function getDuplicidadeWay()
	{
		if(Way::verifyWay() ){

			$sql = new Sql();
			$rtl = $sql->select("
				SELECT 	way.id_way as id_link ,
				r.name as nameOption,
				alt.id_alt,
				alt.name as nameAlt
				FROM way 
				INNER JOIN way_alternative AS wal
				ON way.id_way = wal.id_way 
				INNER JOIN opts_alternatives AS alt 
				ON wal.id_alt = alt.id_alt 
				INNER JOIN opts_registers as r 
				on alt.id_option = r.id_option
				WHERE way.id_way = :id_way and r.id_option !=1 and r.id_option != 2 and r.id_option != 3
				ORDER BY r.id_option

				",array(
					'id_way'=>$_SESSION[Way::IDENTIFYWAY]
				));
			if(count($rtl)>0){
				return $rtl;
			}else {

				Information::setError_record('Não encontrado o way');
			}
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

		$this->setLinksAlternativs( $ndata);
	}
	public static function getMenuAlternativesAlterLink($linkdata= array())
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
					return Links::formatMenuAlternativasAlterararLink($data , $linkdata);
				}else {
					Information::setError_record('Erro ao pegar os dados');		
				}
			}else{
				Information::setError_record('Não encontrado a tabela de menu');		
				return false; 
			}
		}	
	}
	public static function formatMenuAlternativasAlterararLink($data , $linkdata)
	{
		$string = ''; 	
		$idcolum = 0 ;
		$countRowElement = 0 ; 
		$tres = array_slice($data,0 ,3);

		foreach ($data as $key => $value) {
			$countRowElement++; 

			 $id_option = "opts_alternatives{$linkdata[$idcolum]['id_liks_alternatives']}" ;
			if($countRowElement == 1 ){
				$string .="<div class='row pt-4'>";	
			}else if($countRowElement  == 4 ){
				$string .="<div class='row pt-5'>";
			}


			$string .="<div class='col'><div class='input-block'>";
			$string .= "<label for='$id_option' class='input-block__label'>{$value['opt']} </label> ";

			$string .="<div class='input-block__cont'>";
			$indice = (string)$key; 
			$compare = isset($tres[$indice]['id_option'])?$tres[$indice]['id_option']:'';
			
			if ($data[$indice]['id_option'] == $compare){
				$string .=   "<select id='$id_option' name='$id_option' class='input-block__select-input'   >";
			$string .="<option selected='true'  disabled='disabled' > </option>";

			}else{
				$string .=       "<select id='$id_option' name='$id_option' class='input-block__select-input'  disabled='disabled'>";
			}

			foreach ($value as $key2 => $value2) {
				if (isset($value2['opt_alt'])) {
					if($value2['id_alt'] == $linkdata[$idcolum]['id_alt']) {
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
	public static function updateLinks( $linkdata ='' , $dataPost = array())
	{	
		
		if(isset($linkdata) && !empty($linkdata) ){
			$id_link = $linkdata['0']['id_link']; 
			$namelinkAtual = $linkdata['0']['namelink']; 
		}
	
		$sql = new Sql(); 

		if(isset($dataPost['namelink']) && !empty($dataPost['namelink'])){
			if($dataPost['namelink'] != $namelinkAtual ){
				$sql->query("
				UPDATE links SET name = :namelink where id_link = :id_link 
			",array(
				":namelink"=>$dataPost['namelink'],
				":id_link"=>(int)$id_link
			));
			$data = array();
			$data['action']= Logs::ACTIONS['Alteração'] ;
			$data ['area']= "links";
			$data['id_item']= (int)$id_link;
			$data['old_value']= $namelinkAtual;
			$data['new_value']=$dataPost['namelink'] ;
			Logs::setUserlogs($data); 

			}
			
		}
	
		foreach ($dataPost as $key => $value) {
			if($dat= explode('opts_alternatives',$key )){
				if(isset($dat['1'])){
					$values[":p" . $key] = (int)$value;
			$args .= "UPDATE liks_alternatives SET id_alt = :p{$key} where id_link = {$id_link} and id_liks_alternatives = {$dat['1']};";
				}	
			}
		}	
		rtrim($args, ";");
		$sql->query($args,$values);
				
		Links::saveAlteracoesLink($linkdata,$values);
	}
	public static function saveAlteracoesLink($linkdata = array(), $newdata = array() ){
		foreach ($linkdata as $key => $value) {
			
			$data = array();
			$data['action']= Logs::ACTIONS['Alteração'] ;
			$data ['area']= "liks_alternatives";
			$data['id_item']= (int)$linkdata[$key]['id_link'];
			$data['old_value']= $linkdata[$key]['id_alt'];
			$data['new_value']= $newdata[':popts_alternatives' . $linkdata[$key]['id_liks_alternatives']];

			Logs::setUserlogs($data); 		 
			
		}

	}

	public static function deletLink($id_link = '')
	{
		$sql = new Sql();
		 $sql->query("DELETE FROM links WHERE id_link = :id_link",
		array("id_link"=> $id_link));

		$data = array();
			$data['action']=Logs::ACTIONS['Exclusão'];
			$data['area']='links and links_alternatives';
			$data['id_item']=(int)$id_link;
			$data['old_value']=$id_link;
			$data['new_value']='';

			Logs::setUserlogs($data);
		
		return true ; 
	}






}
