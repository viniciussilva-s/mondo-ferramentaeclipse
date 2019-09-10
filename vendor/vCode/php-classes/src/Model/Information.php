<?php
namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;

Class Information extends Model{
	const ERROR_GENERAL = "ERROR_GENERAL";
	const SUCCESS_GENERAL = "SUCCESS_GENERAL";	

	const ERROR_RECORD = "ERROR_RECORD";
	const SUCCESS_RECORD = "SUCCESS_RECORD";
	
	const USU_INEXISTENTE = 5; 

	//   function Error 
	public static function setError_general($msg='', $data=array())
	{
		if(isset($msg) and!empty($msg)){
			$_SESSION[self::ERROR_GENERAL] = $msg ; 
		}	

		if(!empty($data)){
			$data['message'] = isset($data['details'])? $msg .' Details:'. $data['details'] :$msg ; 
			Information::setSystemLogs($data);		
		} 
	}
	public static function setSystemLogs($data = array())
	{
		$sql = new Sql();
		$rtl = $sql->query("
			INSERT INTO system_logs
			(id_user, page, action, message) 
			VALUES (:id_user, :page, :action, :message)
			",array(
				':id_user'=>(int)$data['id_user'],
				':page'=>$data['page'],
				':action'=>(int)$data['action'],
				':message'=>$data['message']
			)); 
	} 
		public static function getError_general()
		{
			if (!empty($_SESSION[self::ERROR_GENERAL])){
				$msg = $_SESSION[self::ERROR_GENERAL];
				self::clearError_general();	
				return $msg;	
			}  
		}

		public static function clearError_general()
		{
		//$_SESSION[self::ERROR_GENERAL]= "";
			unset($_SESSION[self::ERROR_GENERAL]);
		}


	//   function Success
		public static function setSuccess_general($msg='')
		{
			if(isset($msg) and !empty($msg)){
				$_SESSION[self::SUCCESS_GENERAL] = $msg ; 
			}
		}
		public static function getSuccess_general()
		{	

			if (!empty($_SESSION[self::SUCCESS_GENERAL])){
				$msg = $_SESSION[self::SUCCESS_GENERAL];
				self::clearSuccess_general();	
				return $msg;
			}  
		}
		public static function clearSuccess_general()
		{
		//$_SESSION[self::SUCCESS_GENERAL]= "";
			unset($_SESSION[self::SUCCESS_GENERAL]);
		}	

// DECLARAÇÃO DE FUNÇÕES DE REGISTRO ================================================================

	//   function Error 
		public static function setError_record($msg='')
		{
			if(isset($msg) and!empty($msg)){
				$_SESSION[self::ERROR_RECORD] = $msg ; 
			}	
		}
		public static function getError_record()
		{
			if (!empty($_SESSION[self::ERROR_RECORD])){
				$msg = $_SESSION[self::ERROR_RECORD];
				self::clearError_record();	
				return $msg;	
			}  
		}
		public static function clearError_record()
		{
		//$_SESSION[self::ERROR_REGI]= "";
			unset($_SESSION[self::ERROR_RECORD]);
		}


	//   function Success
		public static function setSuccess_record($msg='')
		{
			if(isset($msg) and !empty($msg)){
				$_SESSION[self::SUCCESS_RECORD] = $msg ; 
			}
		}
		public static function getSuccess_record()
		{	

			if (!empty($_SESSION[self::SUCCESS_RECORD])){
				$msg = $_SESSION[self::SUCCESS_RECORD];
				self::clearSuccess_record();	
				return $msg;
			}  
		}
		public static function clearSuccess_record()
		{
		//$_SESSION[self::SUCCESS_GENERAL]= "";
			unset($_SESSION[self::SUCCESS_RECORD]);
		}	

	}


	?>