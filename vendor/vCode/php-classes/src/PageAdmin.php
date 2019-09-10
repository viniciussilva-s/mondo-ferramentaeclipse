<?php

namespace vCode;
use Rain\Tpl;


//require_once('/novoeclipse/desenUserLogin/vendor/rain/raintpl/library/Rain/Tpl');
use \vCode\Model\User;
	
	class PageAdmin{
		private $tpl;
		private $options;
		private $defaults = [
			"header"=>true,
			"footer"=>true,
			"data"=>[]
		];
		

		private $dirHost = "/home/storage/2/e1/22/catalogoclaro/public_html/mondo/";

//		private $dirTest = "C:/xampp/htdocs/desv/desenUserLogin/";
	
	public function __construct($opts = array(),$typeTpl = 'php', $tpl_dir ="views/admin/"){
			
			$this->options = array_merge($this->defaults,$opts);	
			
			// config
			$config = array(
							"tpl_dir"       => $this->dirHost.$tpl_dir,
							"cache_dir"     => $this->dirHost."/views-cache/",
							"debug"         => false // set to false to improve the speed
						   );
			// if($typeTpl ==='php' ){
			// } else{
			// 	Tpl::configure( $config );
			// }
				Tpl::configure( $config , 'php' );
			
			 
			$this->tpl = new tpl;
			$this->setData($this->options['data']);
			
			
			if ($this->options['header']===true){

				$this->tpl->draw("header-claro");
				
			} 
		}
		
		private function setData($data = array()){
			foreach($data as $key => $value ){
				$this->tpl->assign($key,$value);
			}
		}
		
		public function setTpl($name,$data=array(),$returnHTML=false){
			
			$this->setData($data);
			
			
			return $this->tpl->draw($name,$returnHTML);
			
		}
		public function __destruct(){
			if ($this->options['footer']===true) $this->tpl->draw("footer-claro");
		}
		
		
	}	


	





?>