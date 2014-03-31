<?php
/*
 * To change this template, choose Tools | Templates
* and open the template in the editor.
*/

/**
 * Description of User
 *
 * @author Tuan-pc
 */
class User {
	public $userGroupId;
	public function __construct(){
		global $connection;
		$query = "SELECT *
				FROM `user`
				WHERE `id` = {$_SESSION['userid']}
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else die('Get Client by IMEI: select prepare returned no statement handle');
		$fetchResult = $sth->fetch(PDO::FETCH_ASSOC);
		$this->userGroupId = $fetchResult['group'];
	}
	public function getUser(){
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
	public function getUserbyUname($username){
		global $connection;
		$query = "SELECT *
				FROM `user`
				WHERE `username` = '{$username}'
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else die('Get Client by IMEI: select prepare returned no statement handle');
		return $sth;
	}
	public function addUser($fname,$uname,$pword,$gid){
		global $connection;
		$date = date("Y-m-d");
		$query = "INSERT INTO `user`(`fullname`,`username`,`password`,`group`,`added`)
				VALUES ('{$fname}','{$uname}','{$pword}',{$gid},'{$date}')
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else die('Get Client by IMEI: select prepare returned no statement handle');
		return $sth;
	}
	public function deleteUser($id){
		global $connection;
		$query = "DELETE
				FROM `user`
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