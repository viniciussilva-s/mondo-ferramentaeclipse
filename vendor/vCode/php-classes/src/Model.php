<?php

namespace vCode;

use vCode\Model\Information;
use vCode\SystemConfigure;
ini_set('default_charset', 'UTF-8');
class model{
	private $values =[];
	public function __call($name,$args){
		$method = substr($name,0,3);
		$fieldName = substr($name,3,strlen($name));
		
		switch ($method){
			case "get":
				return (isset($this->values[$fieldName])? $this->values[$fieldName] : NULL);
			break;
			
			case "set":
				 $this->values[$fieldName] = $args[0];
			break;
		}
	
	}
	public function setData($data = array()){
		$data = self::decodeUTF8($data);
		foreach($data as $key => $value){
			$this->{"set".$key}($value);
		}
	}
	public function getValues(){
		return $this->values;
	}

	public static function movelocationUser($location='' ,$home = false)
	{
		if(isset($location)&& !empty($location) ){
			if($home){
				//$base = SystemConfigure::BASEURL; http://catalogoclaro.comercial.ws/mondo/index.php/admin/login
				header("Location: http://catalogoclaro.comercial.ws/mondo/index.php/admin");
			}else {
				header("Location: http://catalogoclaro.comercial.ws/mondo/index.php/admin{$location}");
			}

		}else{
			Information::setError_record('Localização inválida');
		}
	}


	public static function decodeUTF8($data = ''){
		 foreach ($data as $key1 => $value1) {
			if (is_array($data[$key1])) {
				foreach ($data[$key1] as $key2 => $value2) {
					if (!is_numeric($value2)){
						$data[$key1][$key2]= utf8_decode($value2);

					} 
				}
			}
		}
		return $data; 
	}
	public static function cleanData($data = ''){
			 $data = trim($data);
			 $data = str_replace(".", "", $data);
			 $data = str_replace(" ", "", $data);
			 $data = str_replace(",", "", $data);
			 $data = str_replace("-", "", $data);
			 $data = str_replace("(", "", $data);
			 $data = str_replace(")", "", $data);
			 $data = str_replace(")", "", $data);		
		return $data;
	}
}



?>