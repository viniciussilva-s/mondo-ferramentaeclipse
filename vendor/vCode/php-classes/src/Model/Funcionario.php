<?php 

namespace vCode\Model;
use \vCode\DB\Sql;
use \vCode\Model;

	/**
	 * 
	 */
	class Funcionario extends Model
	{
		
		public static function listAll()
		{	
			$sql = new Sql();
			$results = $sql->select("SELECT * 
					FROM users as a
					WHERE a.iduser > :iduser",	
					array(":iduser" => 1)
				);
			if(!empty($results[0]) and is_array($results)){
				return parent::encodeUTF8($results);	
			}

		}
		public static function getUserSearch($search)
		{
			$sql = new Sql() ;
			$results = $sql->select("
				SELECT  * 
				FROM users as a
				WHERE a.username LIKE :search and a.inadmin = 0 
	        	ORDER by a.username
			",array(
				":search"=>'%'. $search .'%'
			
			));
			if(!empty($results[0]) and is_array($results)){
				return $results;	

			}else{
				return false;
			}		
		}
		public  function getIduser($iduser='')
		{
			$sql = new Sql() ;
			$results = $sql->select("
				SELECT  * 
				FROM users as a
				WHERE a.iduser = :iduser  
			",array(
				":iduser"=> $iduser
			
			));
			if(!empty($results[0]) and is_array($results)){
			//$results[0]['despassword'] = User::sslDec($results[0]['despassword']);
			$this->setData($results[0]);
			return true;	

			}else{
				return false;
			}	
		}
		public function inSave() {
			$sql = new Sql();
			$sql->select(
				"INSERT INTO 
					users(
					username, desemail, despassword, inadmin ,image) 
					VALUES (
					:username, :desemail, :despassword, :inadmin ,:image) 
				" ,
				array(
					':username'=>$this->getusername(),
					 ':desemail'=>$this->getdesemail(),
					 ':despassword'=>User::sslEnc($this->getdespassword()),
					 ':inadmin'=>$this->getinadmin(),
					 ':image'=>$this->getimage()
				)
			);
		}
		public function save($iduser){
			$sql = new Sql();
			$getiduser = $this->getiduser();
			$iduser = isset($getiduser)?$iduser:$this->getiduser();
			$despassword = User::sslEnc($this->getdespassword());
			
			


			$sql->select(
				" UPDATE 
					users
					SET 
					username =:username , 
					desemail= :desemail, 
					despassword = :despassword,
					 inadmin =:inadmin,
					 image =:image
					WHERE iduser = :iduser 
				" ,
				array(
					':iduser'=>$iduser,
					':username'=>$this->getusername(),
					 ':desemail'=>$this->getdesemail(),
					 ':despassword'=>$despassword,
					 ':inadmin'=>$this->getinadmin(),
					 ':image'=>$this->getimage()
				)
			);
		}
		public static function delete($iduser){
			$sql = new Sql();
			$sql->select("
				DELETE FROM 
				users 
				WHERE iduser = :iduser",
				array(":iduser"=>$iduser)
			);

		}
		public function formatImage($file='' , $dataPost = array())
		{			
			//$file  = $_FILES["fileUpload"];
			   if($file['error']){
			      throw new Exception ("Error: ".$file['error']);
			    }
			    $dirUploads = "imagens";
			    if(!is_dir($dirUploads)){
			      mkdir($dirUploads);
			    }
			    
			    $fileName = explode('.',$file['name']);
			    $fileName[0] = Parent::cleanData($dataPost['username']);
			    $file['name'] = $fileName[0].".".$fileName[1];
			    if(move_uploaded_file($file["tmp_name"],$dirUploads. DIRECTORY_SEPARATOR . $file['name'])){
			      //echo "Upload realizado com sucesso!" ; 
			    	return $file['name'];
			    }else{
			      throw new Exception ("Não foi possivel realizar o upload");
			    }
		}
		public function setData($dataPost = array(), $fileImage = array() ){

			if(!empty($fileImage)){
				if($image = $this->formatImage($fileImage , $dataPost)){
					$dataPost['image'] = $image;
				}
			}
			Parent::setData($dataPost);
		}


}
	
 ?>