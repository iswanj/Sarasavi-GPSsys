<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Client
 *
 * @author Tuan-pc
 */
class Client {
    //put your code here
    public $clientName = '';
    public $clientSpeed = '';
    
    public static function getClient(){
        global $connection;
        $query = "SELECT *
                FROM `clients`
                ";
        $sth = $connection->prepare($query);
        if($sth) {
                $sth->execute();
                $_SESSION['global_error'] = '';
        }
        else die('Get Client : select prepare returned no statement handle');
        return $sth;
    }
    
    public static function getClientbyImei($imei){
        global $connection;
        $query = "SELECT *
                FROM `clients`
                WHERE `imei` = '{$imei}'
                ";
        $sth = $connection->prepare($query);
        if($sth) {
                $sth->execute();
                $_SESSION['global_error'] = '';
        }
        else die('Get Client by IMEI: select prepare returned no statement handle');
        return $sth;
    }
    
    public static function getClientbyGid($gid){
    	global $connection;
    	$query = "SELECT *
		    	FROM `clients`
		    	WHERE `g_id` LIKE '%{$gid}%'
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
    		$sth->execute();
    		$_SESSION['global_error'] = '';
    	}
    	else die('Get Client by Group: select prepare returned no statement handle');
    	return $sth;
    }
    public static function getlocbyclid($id){
    	global $connection;
    	$query = "SELECT *
		    	FROM `location`
		    	WHERE `c_id` = {$id}
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
    		$sth->execute();
    		$_SESSION['global_error'] = '';
    	}
    	else die('Get Client by Group: select prepare returned no statement handle');
    	return $sth;
    }
    public static function getClientbyId($id){
    	global $connection;
    	$query = "SELECT *
		    	FROM `clients`
		    	WHERE `id` = {$id}
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
	    	$sth->execute();
	    	$_SESSION['global_error'] = '';
    	}
    	else die('Get Client by their id: select prepare returned no statement handle');
    	return $sth;
    }
    public static function getAllClientLocations($vid,$date){
    	global $connection;
    	$query = "SELECT *
		    	FROM `location`
		    	WHERE `c_id` = {$vid} AND `date` LIKE '%{$date}%'
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
	    	$sth->execute();
	    	$_SESSION['global_error'] = '';
    	}
    	else die('Get Locations: select prepare returned no statement handle');
    	return $sth;
    }
    public static function getGroup(){
    	global $connection;
    	$query = "SELECT *
		    	FROM `group`
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
    	$sth->execute();
    		$_SESSION['global_error'] = '';
    	}
    	else die('Get Groups: select prepare returned no statement handle');
    	return $sth;
    }
    public static function getGroupbyId($id){
    	global $connection;
    	$query = "SELECT *
		    	FROM `group`
		    	WHERE `id` = {$id} 
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
    		$sth->execute();
    		$_SESSION['global_error'] = '';
    	}
    	else die('Get Group by id: select prepare returned no statement handle');
    	return $sth;
    }
    
    public static function addVehicle($group,$imei,$clientname){
    	global $connection;
    	$date = date("Y-m-d");
    	$query = "INSERT INTO `clients` (`g_id`,`imei`,`client_name`,`added`)
    			VALUES ('{$group}','{$imei}','{$clientname}','{$date}')
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
	    	$sth->execute();
	    	$_SESSION['global_error'] = '';
    	}
    	else die('Add Vehicle: select prepare returned no statement handle');
    	return $sth;
    }
    public function deleteClient($id){
    	global $connection;
    	$date = date("Y-m-d");
    	$query = "DELETE
		    	FROM `clients`
		    	WHERE `id` = {$id}
		    	";
    	$sth = $connection->prepare($query);
    	if($sth) {
    		$sth->execute();
    		return 1;
    	}else{
    		return 0;
    	}
    }
}

?>
