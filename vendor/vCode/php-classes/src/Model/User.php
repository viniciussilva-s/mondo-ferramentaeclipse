<?php
namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;
use \vCode\SystemConfigure;
use \vCode\Model\Information;

Class User extends Model{
	const SESSION = "User";
	const SECRET = "viniciussouza";
	const PASSWORD_DEFAULT = "Mudar123";
	const USER_ROLES = [ 
		'NULL'=>4

	];
//	const IDENTIFYWAY = "IDENTIFYWAY";

	public static function getFromSession(){
		$user = new User();
		
		if(isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['id_user'] > 0)
		{
			$user->setData($_SESSION[User::SESSION]);
		}
		return $user;
	}
	public static function verifyLogin($inadmin = true){
		if (!User::checkLogin($inadmin)){
			if($inadmin){
				header("Location: ".SystemConfigure::BASEURL."index.php/admin/login");				
			}else{
				header("Location: ".SystemConfigure::BASEURL."index.php/login");
				//header('Location: /login');	
			}
			exit;
		}else{

		}

	}
	public static function checkLogin($viewperfil = true){
		if(
			!isset($_SESSION[User::SESSION])			
			||
			!$_SESSION[User::SESSION]
			||
			!(int)$_SESSION[User::SESSION]['id_user']>0		
		){
			// Usuario não esta Log
			return false ; 
		}else{

			$viewperfil = isset($_SESSION[User::SESSION]['id_user_role'])?$_SESSION[User::SESSION]['id_user_role']:'2'; 
			switch ($viewperfil) {
			 	case $viewperfil == 1: //admin
			 		//Information::setSuccess_general('Usuário é admin');	
			 	return true;
			 	break;
			 	case $viewperfil == 2: // colaborador 
			 	User::requestsPermission(); 	
			 	return true;
			 	break;

			  	default: //nenhum perfil
			  	return false;
			  	break;
			  } 

			}
		}
		public static function requestsPermission()
		{	
			$perfilUser = explode("/mondo/index.php/admin" , $_SERVER['REQUEST_URI']); 	
			if($url = explode("/onlyAdmin" , $perfilUser['1'])){
				if (isset($url['1'])) {
					Information::setError_general('Você não possui permissão para acesso a essa página',$data );
					User::movelocationUser('/index',true);
					exit();
			 			# code...
				}	
			}
		}
		public static function isexistsUser($data =array())
		{
			$sql = new Sql();
			$rlt = $sql->select("
				SELECT * 
				FROM users as u 
				INNER JOIN user_roles as r 
				on u.id_user_role = r.id_user_role
				WHERE  u.email = :email
				",	
				array(
					":email" =>$data['email']
				));
			if (count($rlt)>0){
				$data = [
					'id_user' => (int)Information::USU_INEXISTENTE,
					'page'=>'/nuser', 
					'action'=> (int)Logs::ACTIONS['Duplicidade'],
					'details' =>' USER:73 email já existente' 
				]; 
				Information::setError_general('Usuário já existente',$data );
				return false;
			}else{
				if(User::inSave($data)){
					return true;	
				}

			}		
		}
		public static function inSave($data = array()) {
			$sql = new Sql();
			$rtl = $sql->query(
				"INSERT INTO 
				users(
				username,email, despassword) 
				VALUES (
				:username,:email, :despassword) 
				" ,
				array(
					':username'=>$data['name'],
					':email'=>$data['email'],
					':despassword'=>User::sslEnc($data['despassword'])					 
				));
			if($rtl >0){
				return true;
			}else{
				$data = [
					'id_user' => (int)Information::USU_INEXISTENTE,
					'page'=>'/nuser', 
					'action'=> (int)Logs::ACTIONS['Criação'],
					'details' =>' USER:113 INSERT INTO USER ' 
				]; 
				Information::setError_general('Error na execução da linha de codigo',$data);
			}
		}
		public static function login($login,$password)
		{	

			$sql = new Sql();
			$results = $sql->select("
				SELECT * 
				FROM users as u 
				INNER JOIN user_roles as r 
				on u.id_user_role = r.id_user_role
				WHERE email = :login
				",	
				array(":login" =>$login	));

			if (count($results)===0){
				Information::setError_general('Usuário inexistente ou senha inválida.');

				User::movelocationUser('/login');

	//		header("Location: ".SystemConfigure::BASEURL."index.php/admin/login");	
				exit();
			}

			$data = $results[0];

			if ($password === User::sslDec($data['despassword'])){
				$user = new User();
			//$data['desname']= utf8_encode($data['desname']);
				$user->setData($data);
				if((int)User::USER_ROLES['NULL']===(int)$user->getid_user_role() ){
					User::movelocationUser('/usernull');
					exit();
				}
				$_SESSION[User::SESSION] = $user->getValues();

				User::movelocationUser('/admis',true);
				// header("Location:  /index.php/admin/login");	
				return $user;
			}else{
				Information::setError_general('Usuário inexistente ou senha inválida.');
				User::movelocationUser('/login');
			//header("Location: ".SystemConfigure::BASEURL."index.php/admin/login");	
				exit();
			}


			return true;
		}	
		public static function listAll($requests=false)
		{	
			$sql = new Sql();
			if($requests){
				// id_user,username, email, namerole
				$rtl = $sql->select("
					SELECT *
					FROM users u
					INNER JOIN user_roles r
					on u.id_user_role = r.id_user_role 
					WHERE r.id_user_role = 4 and u.id_user != 5  and u.id_user != 1
					");

			}else{

					 //id_user,username, email, name_role
				 // id_user,username, email, namerole
				$rtl= $sql->select("
					SELECT* 
					FROM users  u
					JOIN user_roles AS r
					ON u.id_user_role = r.id_user_role
					WHERE u.id_user != 1 and u.id_user !=5  and r.id_user_role !=4 and r.id_user_role !=1 
					");

			}
			if(count($rtl)>0){
				return $rtl;
			}
		}

		public  function getIduser($iduser='')
		{
			$sql = new Sql() ;
			$rtl = $sql->select("
				SELECT  * 
				FROM users as u
				INNER JOIN user_roles as r 
				ON r.id_user_role = u.id_user_role 
				WHERE r.id_user_role != 4 
				and r.id_user_role != 1 
				and  id_user = :id_user
				",array(
					":id_user"=> $iduser

				));

			if(count($rtl)>0){
				$this->setData($rtl[0]);
				return true;	

			}else{
				return false;
			}	
		}

		public static function release_access($id_user = '')
		{

			$sql = new Sql(); 
			$sql->query("
				UPDATE users SET
				id_user_role= :role
				WHERE id_user = :id_user
				",array(
					':id_user'=>$id_user,		
					':role'=>2		
				));

			$data=[
				'action'=>Logs::ACTIONS['Liberação de acesso'] ,
				'area'=>'release_access',
				'id_item'=>(int)$id_user ,
				'old_value'=>'acesso',
				'new_value'=>'role 2' 
			];


			$logs = new Logs();
			Logs::setUserlogs($data);


		}
		public function resetPassword()
		{
			$sql = new Sql();
			$sql->query("UPDATE users SET
				despassword = :despassword
				WHERE id_user = :id_user and id_user_role= :role
				",array(
					':id_user'=>$this->getid_user(),
					':role'=>2,
					":despassword"=>User::sslEnc(User::PASSWORD_DEFAULT)		
				));

			$data=[
				'action'=>Logs::ACTIONS['Reset de senha'] ,
				'area'=>'resetPassword',
				'id_item'=>(int)$this->getid_user(),
				'old_value'=>'despassword',
				'new_value'=>'Senha Padrão'
			];


			$logs = new Logs();
			Logs::setUserlogs($data);
		}

		public function alterPermission($dataPost = array())
		{
			$sql = new Sql();
			$sql->query("UPDATE users SET
				id_user_role = :id_user_role 
				WHERE id_user = :id_user and id_user_role= :role
				",array(
					':id_user'=>$this->getid_user(),
					':role'=>2,
					':id_user_role'=>$dataPost["selectAlterPermission"],
					":despassword"=>User::sslEnc(User::PASSWORD_DEFAULT)		
				));

			

			$data=[
				':action'=>Logs::ACTIONS['Mudar Perfil'] ,
				':area'=>'alterPermission',
				':id_item'=>(int)$this->getid_user(),
				':old_value'=>'',
				':new_value'=>$dataPost["selectAlterPermission"]
			];


			$logs = new Logs();
			Logs::setUserlogs($data);
		}



		public static function logout()
		{
			$_SESSION[User::SESSION] = NULL;
		}

		public static function sslEnc($msg)
	{ # --- ENCRYPTION ---
		if(function_exists('openssl_encrypt')){
			list ($method , $pass, $iv , $option)= User::sslPrm();
			return openssl_encrypt($msg, $method , User::SECRET , $option, $iv);
		}
	}
	
	public static function sslDec($msg)
	{ # --- DECRYPTION ---
		list ($method , $pass, $iv ,$option )= User::sslPrm();
		if(function_exists('openssl_decrypt')){
			return  openssl_decrypt($msg , $method ,  User::SECRET , $option , $iv);
		}
	}
	public static function sslPrm()
	{
		$iv = '1234567812345678';//openssl_random_pseudo_bytes(19);
		$option = 0;
		return array("aes-128-cbc", User::SECRET, $iv , $option);
	}

}


?>