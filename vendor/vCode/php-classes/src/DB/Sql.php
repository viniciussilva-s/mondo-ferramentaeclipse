<?php 

namespace vCode\DB;

use vCode\SystemConfigure; 
ini_set('default_charset', 'UTF-8');
class Sql {

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"mysql:dbname=".SystemConfigure::DBNAME.";host=".SystemConfigure::HOSTNAME, 
			SystemConfigure::USERNAME,
			SystemConfigure::PASSWORD
		);
		$this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->conn->query("SET NAMES utf8");

	}

	private function setParams($statement, $parameters = array())
	{
		

		foreach ($parameters as $key => $value) {
					
			$this->bindParam($statement, $key, $value);

		}

	}

	private function bindParam($statement, $key, $value)
	{

		$statement->bindParam($key, $value);

	}

	public function query($rawQuery, $params = array())
	{

		try {
			$stmt = $this->conn->prepare($rawQuery);

			$this->setParams($stmt, $params);

			$test = $stmt->execute();


			if(strpos($rawQuery, 'INSERT') !== false){
				return $this->conn->lastInsertId(); 
		
			}
		} catch (Exception $e) {
			return $e->getMessage(); 
		}

	}

	public function select($rawQuery, $params = array()):array
	{
		try {


		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);
	
		$stmt->execute();
		
		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			return $e->getMessage(); 
			
		}

	}



}
 ?>