<?php 
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../includes/function.php';
	require_once '../classes/User.php';
	require_once '../classes/Client.php';
	
	
	if(isset($_GET['delid'])){
		$nclient = new Client();
		$delclient = $nclient->deleteClient($_GET['delid']);
		if($delclient == 1){
			// deleted
			$_SESSION['errormsg'] = "Client Deleted";
			redirect_to('../vehicle.php?m=com');
		}else{
			// delete faild
			$_SESSION['errormsg'] = "Deleting unsuccessful";
			redirect_to('../vehicle.php?m=com');
		}
		
	}
	
	
	
?>