<?php

class Vehicle {
	public function getVehicle(){
		global $connection;
		$query = "SELECT *
				FROM `user`
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else die('Get Client by IMEI: select prepare returned no statement handle');
		return $sth;
	}
}

?>