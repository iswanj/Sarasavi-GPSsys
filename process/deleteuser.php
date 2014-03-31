<?php 
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../includes/function.php';
	require_once '../classes/User.php';
	require_once '../classes/Client.php';
	
	
	if(isset($_GET['delid'])){
		$nuser = new User();
		$deluser = $nuser->deleteUser($_GET['delid']);
		if($deluser == 1){
			// deleted
			$_SESSION['errormsg'] = "User Deleted";
			redirect_to('../users.php?m=com');
		}else{
			// delete faild
			$_SESSION['errormsg'] = "Deleting unsuccessful";
			redirect_to('../users.php?m=com');
		}
		
	}
	
	
	
?>