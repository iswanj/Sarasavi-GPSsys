<?php if(!ob_start()) { ob_start(); } ?>
<?php
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../includes/function.php';
?>
<?php 
	if($_POST['username'] == '' || $_POST['password'] == ''){
		redirect_to('../login.php');
	}
	if(isset($_POST['username']) && isset($_POST['password'])){
		$username = trim($_POST['username']);
		$password = $_POST['password'];
		$hashpass = ($password);
		$sql = "SELECT *
				FROM `user`
				WHERE `username` = '{$username}' && `password` = '{$hashpass}'
				LIMIT 1
				";
		$sth = $connection->prepare($sql);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else die('Get Client by IMEI: select prepare returned no statement handle');
		if($sth->rowCount() == 1){
			$fetchResult = $sth->fetch(PDO::FETCH_ASSOC);
			echo $_SESSION['user_id'] = $fetchResult['id'];
			$_SESSION['userfname'] = $fetchResult['fullname'];
			$_SESSION['error_msg'] = '';
			$_SESSION['usergroup'] = explode(',',$fetchResult['group']);
			redirect_to('../index.php');
		}else{
			echo $_SESSION['error_msg'] = "Username or Password is incorrect";
			redirect_to('../login.php');
		}
	}
?>