<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;

	/**
	 * 
	 */
	class Logs extends Model
	{	
		const ACTIONS = [
				'Criação'=> 1 ,
				'Visualização'=> 2 ,
				'Alteração'=> 3 ,
				'Exclusão'=> 4 ,
				'Duplicidade'=> 5,
				'Senha Inválida' => 6,
				'Liberação de acesso' => 7,
				'Reset de senha' => 8,
				'Mudar Perfil' => 9

			];
		

		public function __construct()
		{
			$sql = new Sql(); 
			$countActions = $sql->select("SELECT * FROM log_actions");

			if (count($countActions) == count(Logs::ACTIONS) ){
				foreach (Logs::ACTIONS as $key => $value) {
					$sql = new Sql(); 
					$sql->query("UPDATE log_actions SET name=:nameActions WHERE id_action = :id_action",
						array(
 							':nameActions'=>$key,
 							':id_action'=>$value
						));
				}
			}else{

				$sql = new Sql(); 
				$values = [];
				$args = "";
				foreach (Logs::ACTIONS as $key => $value) {
					$values[":p" . $value] =  $key;
					$args .= "(:p$value),";
				}

				$values[':id_action'] = (int)0;
				$args = rtrim($args, ",");
				$rtl= $sql->query("
					DELETE FROM log_actions WHERE id_action > :id_action;
					ALTER TABLE log_actions AUTO_INCREMENT = 1;
					INSERT INTO log_actions(name) VALUES $args"
					,$values);
			}
		}
		public static function setUserlogs($data = array() , $notError = true)
		{
			$logs = new Logs ();
			if(!empty($data['action'])){
				$sql = new Sql();
				$rtl = $sql->query("INSERT INTO user_logs(id_user, action, area, id_item, old_value, new_value) VALUES (:id_user, :action, :area, :id_item, :old_value, :new_value)",array(
					':id_user'=>(int)$_SESSION[USER::SESSION]['id_user'],
					':action'=>$data['action'] ,
					':area'=>$data['area'],
					':id_item'=>(int)$data['id_item'] ,
					':old_value'=>$data['old_value'],
					':new_value'=>$data['new_value']  
				)); 
			}
			$action_inv = array_flip(Logs::ACTIONS);
			$value = empty($data['new_value'])?$data['old_value']:$data['new_value'] ;	

			if($notError){
				return false; 				
			}
			
			if( isset($rtl) && !empty($rtl)){	
				Information::setSuccess_record("-> ". $action_inv[$data['action']] ." - " .$value );
			}else{
				Information::setError_record("-> ". $action_inv[$data['action']] ." - " . $value );
			}
		}
			
	}
	
 ?>