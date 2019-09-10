<?php
namespace vCode\Model;

use \vCode\DB\Sql;
use \vCode\Model;
use \vCode\Model\Information;
use \vCode\Model\Logs;

Class ConfigureMenu extends Model{

	const OPTIONDEFAULT = [
		'Marca'=> 1,
		'Categoria'=> 2,
		'Produto'=> 3,
		'Assunto Geral'=> 4,
		'Segmento'=> 5,
		'Assunto Especifico'=> 6
	]; 

	public function __construct()
	{
		$sql = new Sql(); 
		$countActions = $sql->select("SELECT * FROM opts_registers");

		if (count($countActions) == count(ConfigureMenu::OPTIONDEFAULT) ){
			foreach (ConfigureMenu::OPTIONDEFAULT as $key => $value) {
				$sql = new Sql(); 
				$sql->query("UPDATE opts_registers SET name=:nameOption WHERE id_option = :id_option",
					array(
						':nameOption'=>$key,
						':id_option'=>$value
					));
			}
		}else{

			$sql = new Sql(); 
			$values = [];
			$args = "";
			foreach (ConfigureMenu::OPTIONDEFAULT as $key => $value) {

				$values[":p" . $value] =  $key;
				$args .= "(:p$value),";
			}

			$values[':id_option'] = (int)0;
			$args = rtrim($args, ",");
			$rtl= $sql->query("
				DELETE FROM opts_registers WHERE id_option > :id_option;
				ALTER TABLE opts_registers AUTO_INCREMENT = 1;
				INSERT INTO opts_registers(name) VALUES $args"
				,$values);
		}
	}



	public static function listAllOptions($search = '' )
	{
		$sql = new Sql(); 
		$rlt = ''; 
		if(isset($search) && !empty($search)){
			$rlt = $sql->select("
				SELECT * 
				FROM opts_registers as opt
				WHERE opt.name LIKE :search 
				order by opt.id_option",
				array(
					':search' =>'%'. $search. '%' 
				)); 
		}else{
			$rlt = $sql->select("
				SELECT * 
				FROM opts_registers as opt
				order by opt.id_option"
			);
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
	public static function listAllAlternatives($search = '' )
	{
		$sql = new Sql(); 
		$rlt = ''; 
		if(isset($search) && !empty($search)){

			$rlt = $sql->select("
				SELECT a.name as 'alternative', 
				a.id_alt, a.created,
				r.name as 'option',
				r.id_option 
				FROM opts_alternatives AS a 
				INNER JOIN opts_registers AS r 
				ON a.id_option = r.id_option
				WHERE a.name LIKE :search 
				ORDER by a.id_alt
				",array(
					':search' => '%'.$search.'%'	
				)); 
		}else{
			$rlt = $sql->select("
				SELECT a.name as 'alternative', 
				a.id_alt, a.created,
				r.name as 'option',
				r.id_option 
				FROM opts_alternatives AS a 
				INNER JOIN opts_registers AS r 
				ON a.id_option = r.id_option
				ORDER by a.id_alt
				");
		}

		if (count($rlt)> 0 ){
			return $rlt;
		} else {
				// Information::setError_record('
				// 	Erro ao retornar dados de configuração do menu. <br><i class="fa fa-arrow-right"></i> Entrar em contato com o suporte
				// 	'); 
				//System Error
			return false; 

		}
	}	
	public static function getMenuAlternatives()
	{
	

			$sql = new Sql(); 

			$rtl = $sql->select("
				SELECT r.name as opt_name,
				r.id_option,
				alt.name as opt_alt,
				alt.id_alt
				FROM opts_registers as r 
				INNER JOIN opts_alternatives as alt 
				on r.id_option = alt.id_option
				ORDER BY r.id_option ASC
				");	
			if(count($rtl)>0){
				$data = array();
				foreach ($rtl as $key => $value) {
					if(array_key_exists($value["opt_name"], $data)){

						array_push($data[$value["opt_name"]]['val'], array('name' => (string) $value['opt_alt'])
									);

						///array_push($data[$value["opt_name"]], $da[$i]);
					}else
					{					
						$data[$value["opt_name"]] = array();
						$data[$value["opt_name"]]['opt'] = $value["opt_name"];
						$data[$value["opt_name"]]['id_option'] = $value["id_option"];
						$data[$value["opt_name"]]['val'] = array();
						array_push($data[$value["opt_name"]]['val'], array(
							"name" =>$value['opt_alt']
						));
						//$data[$value["opt_name"]] = array($value["opt_alt"]);
					}
					sort($data[$value["opt_name"]]['val']);
				}

				if(is_array($data)){
					return $data ;
				}else {
					Information::setError_record('Erro ao pegar os dados');		
				}
			}else{
				Information::setError_record('Não encontrado a tabela de menu');		
				return false; 
			}
			
	}

	

	/// ========================Configure Opção
	public function setOptionMenu()
	{
			// $nopts_registers = $this->getopts_registers(); 

			// if(ConfigureMenu::verify_configurationmenu($nopts_registers, 'opts_registers')){
			// 	return false;
			// }

			// else{
			// 	$sql = new Sql(); 
			// 	$rtl = $sql->query("
			// 				INSERT INTO opts_registers(name)
			// 				VALUES (:name)",array(
			// 				":name"=>$nopts_registers
			// 		));
			// 	if(isset($rtl) && !empty($rtl)){	
			// 		$data = [
			// 			'action'=> Logs::ACTIONS['Criação'],
			// 			'area' => 'opts_registers',
			// 			'id_item'=> $rtl ,
			// 			'old_value'=>'',
			// 			'new_value' => $this->getopts_registers()
			// 		];
			// 		Logs::setUserlogs($data,false); 
			// 		//Information Success
			// 	}else{
			// 			Information::setError_record('Erro -setConfiguremenu ');
			// 	} 

			// }
	}
	public static function getOption($id_option ='')
	{
		if(!empty($id_option)){
			$sql = new Sql();
			$rtl = $sql->select("
				SELECT r.name as nameOption,
				alt.name as altname,
				r.id_option ,
				alt.id_alt 
				FROM opts_registers as r
				INNER JOIN opts_alternatives as alt
				on r.id_option = alt.id_option 
				WHERE r.id_option = :id_option 	and 
				alt.id_alt != 106  and
				alt.id_alt != 107  and
				alt.id_alt != 108  and
				alt.id_alt != 109  and
				alt.id_alt != 110  and
				alt.id_alt != 122  and
				alt.status_alternatives = 1 

				",array(
					':id_option'=>$id_option
				)); 
			if(count($rtl) > 0 ){
				//$this->setData($rtl['0']);
				return $rtl ;
			}else{
				Information::setError_record('Não encotrado');
			}

		}else{
			Information::setError_record('Opção vazia');

		}
	}
	public function saveOption($data_post = array())
	{
		if(ConfigureMenu::verify_configurationmenu($data_post['opts_registers'], 'opts_registers')){
			return false;
		}

		if(is_array($data_post)  &&(!empty($data_post)) ){
			$sql = new Sql();
			$sql->query("
				UPDATE opts_registers 
				SET name = :name
				WHERE id_option = :id_option
				",array(	
					':name'=>$data_post['opts_registers'],
					':id_option'=>$this->getid_option()
				));

			$data = [
				'action'=> Logs::ACTIONS['Alteração'],
				'area' => 'opts_registers',
				'id_item'=>(int)$this->getid_option(),
				'old_value'=>$this->getname(),
				'new_value' => $data_post['opts_registers']
			];
			Logs::setUserlogs($data ,false);
				//Information Success




		}	
	}
	public function deleteOption()
	{	
		$sql = new Sql(); 
		$sql->query("DELETE 
			FROM opts_registers 
			WHERE id_option = :id_option",array(
				':id_option'=>$this->getid_option()	
			));
		$data = [
			'action'=> Logs::ACTIONS['Exclusão'],
			'area' => 'opts_registers',
			'id_item'=>(int)$this->getid_option(),
			'old_value'=>$this->getname(),
			'new_value' =>''
		];

		Logs::setUserlogs($data,false);	
			//Information Success
	}








	/// ======================== Configure Alternativa
	public function setAlternativeMenu()
	{

		$data = $this->getValues();
		$sql = new Sql(); 

		if(isset($data['tags'])){

			$id_option = (int)$data['grupo'];
			foreach ($data['tags'] as $key => $value) {
					$values[":p" . $key] = $data['tags'][$key] ; //(int)$value;
					$args .= "($id_option , :p$key ),";
				}

			}

			$args = rtrim($args, ",");


			$values = array_map("utf8_encode", $values);

			$rtl = $sql->query("
				INSERT INTO opts_alternatives
				(id_option, name) 
				VALUES $args ON DUPLICATE KEY UPDATE
				id_option = VALUES(id_option),
				name = VALUES(name)
				",$values);

			if(isset($rtl) && !empty($rtl)){	
				$data = [
					'action'=> Logs::ACTIONS['Criação'],
					'area' => 'opts_alternatives',
					'id_item'=> $rtl ,
					'old_value'=>'',
					'new_value' => $opts_alternatives
				];

				Logs::setUserlogs($data,false);
					//Success Alternativa

				//ConfigureMenu::movelocationUser("/list/config-alt/claro");
			}else{
				Information::setError_record('Erro - opts_alternatives ');
			} 

		}
		public function getAlternative($id_alt ='')
		{
			if(!empty($id_alt)){
				$sql = new Sql();
				$rtl = $sql->select("
					SELECT * 
					FROM opts_alternatives
					WHERE id_alt = :id_alt 	
					",array(
						':id_alt'=>$id_alt
					)); 

				var_dump($id_alt);
				if(count($rtl) > 0 ){


					$this->setData($rtl['0']);
				}else{
					Information::setError_record('Não encotrado');
				}
			}else{
				Information::setError_record('Opção vazia');
			}
		}
		public function saveAlternative($data_post = array())
		{
			if(is_array($data_post) &&(!empty($data_post))){
				$sql = new Sql();
				$sql->query("
					UPDATE opts_alternatives 
					SET name = :name
					WHERE id_alt = :id_alt
					",array(	
						':name'=>$data_post['nameAlt'],
						':id_alt'=>$this->getid_alt()
					));
				$data = [
					'action'=> Logs::ACTIONS['Alteração'],
					'area' => 'opts_alternatives',
					'id_item'=>(int)$this->getid_alt(),
					'old_value'=>$this->getname(),
					'new_value' => $data_post['nameAlt']
				];
				Logs::setUserlogs($data,false);
				ConfigureMenu::movelocationUser("/config-alt/".$this->getid_option()."/claro/onlyAdmin");
			 exit();

			}	
		}
		public function deleteAlternative()
		{	
			$sql = new Sql(); 
			$sql->query("
					UPDATE opts_alternatives 
					SET 
					status_alternatives = :status
					WHERE id_alt = :id_alt
				",
				array(
					':id_alt'=>$this->getid_alt(),	
					':status'=>0	
				));
			$data = [
				'action'=> Logs::ACTIONS['Exclusão'],
				'area' => 'opts_alternatives',
				'id_item'=>(int)$this->getid_alt(),
				'old_value'=>$this->getname(),
				'new_value' =>''
			];

			Logs::setUserlogs($data,false);	
			ConfigureMenu::movelocationUser("/config-alt/".$this->getid_option()."/claro/onlyAdmin");
		}
	/// ======================== Function geral 
		public static function verify_configurationmenu($nameSearch='', $tableSearch= '')
		{	
			$sql = new Sql();
			if($tableSearch === "opts_registers" ){
				$rtl = $sql->select("
					SELECT r.name, r.id_option as id_search 
					FROM opts_registers as r 
					WHERE r.name = :nameSearch",
					array(
						':nameSearch'=>$nameSearch
					));
			}else{
				$rtl = $sql->select("
					SELECT al.name, al.id_alt as id_search  
					FROM opts_alternatives as al 
					WHERE al.name = :nameSearch",
					array(
						':nameSearch'=>$nameSearch
					));
			}
			if(count($rtl) > 0){
				Information::setError_record('-> Erro Duplicidade - Opção já existente');

				if(isset($rtl['0']['id_search'])  && !empty($rtl['0']['id_search'])){
					$data = [
						'action'=> Logs::ACTIONS['Duplicidade'],
						'area' => $tableSearch,
						'id_item'=> (int)$rtl['0']['id_search'],
						'old_value'=>$rtl['0']['name'],
						'new_value' => $nameSearch
					];
					Logs::setUserlogs($data,false);
				}

				return true;
			}else{
				return false;
			}
		}

	}?>
