<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;

	class Prev_registers extends Model
	{
		public static function listAll($search = '')
		{
			$sql = new Sql() ; 
			if(isset($search) && !empty($search)){
				$rlt = $sql->select("
						SELECT * 
						FROM prev_registers as prevR
						WHERE prevR.original_menu LIKE :search
						OR prevR.original_local LIKE :search
						OR prevR.name LIKE :search
						order by prevR.id_register",
						array(
							':search' =>'%'. $search. '%' 
						)); 
			}else{
				$rlt = $sql->select("
						SELECT * 
						FROM prev_registers as prevR
						order by prevR.id_register"
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
		public function save()
		{
			$sql = new Sql () ;    			
			if($this->getkeep_content()){
				$this->setdescription('');
				
			}
			$rtl = $sql->query("
				INSERT INTO prev_registers
				(original_menu, original_local, name, keep_content, description) 
				VALUES (:original_menu, :original_local, :name, :keep_content, :description)	
				",array(
					':original_menu'=>$this->getoriginal_menu(),
					':original_local'=>$this->getoriginal_local(), 
					':name'=>$this->getname(),
					':keep_content'=>$this->getkeep_content(),
					':description'=>$this->getdescription()
				));
			if(isset($rtl) && !empty($rtl)){
			
			// 	$this->data['area'] = $this->data['area']
			// die; 
				// if($this->getkeep_content()){
				// 	$rtl = $sql->query("INSERT INTO new_registers(id_prev_registers) VALUES (:id_prev_registers)",array(
				// 		':id_prev_registers'=> ''
				// 	));
				// 	$sql->query("INSERT INTO new_menus(id_register) VALUES (:id_register)",array(
				// 		':id_register'=> ''
				// 	));

				// }

				$field_alt = [
					'original_menu'=>$this->getoriginal_menu(),
					'original_local'=>$this->getoriginal_local(), 
					'name'=>$this->getname(),
					'description'=>$this->getdescription(),
				];
				foreach ($field_alt as $key => $value) {
					// $data = [
					// 	'action'=> Logs::ACTIONS['Criação'],
					// 	'area' => "prev_registers - $key"  ,
					// 	'id_item'=> $rtl ,
					// 	'old_value'=>'',
					// 	'new_value' => $value
					// ];
					$this->data['id_item'] = $rtl ; 
					$this->data['area'] = "prev_registers - $key" ; 
					$this->data['new_value'] = $value; 

					Information::setSuccess_record('OOOOK - prev_registers ');
					Logs::setUserlogs($this->data);
			
				}
			}else{
					Information::setError_record('Erro -prev_registers ');
			} 

		
		}
		public function setValues_inUserLogs($value='')
		{
			# code...
		}


	}
 ?>