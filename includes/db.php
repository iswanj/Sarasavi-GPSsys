<?php

class Db
{
	protected $connection;
	private $hostname, $hostuser, $hostpass, $database;
	
	public function __construct($host,$user,$pass,$db){
		$this->hostname = $host;
		$this->hostuser = $user;
		$this->hostpass = $pass;
		$this->database = $db;
	}
	public function open(){
		try {
			$this->connection = new PDO('mysql:host=' . $this->hostname . ';dbname=' . $this->database, $this->hostuser, $this->hostpass,
					array( PDO::ATTR_PERSISTENT => true ));
		} catch (PDOException $e) {
			//$_SESSION['global_error'] .= $e->getMessage() . "\r\n";
			echo $e->getMessage() . "\r\n";
		}
		
		return $this->connection;
	}
	public function close(){
		unset($this->connection);
	}
}
?>