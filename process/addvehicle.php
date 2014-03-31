<?php
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../classes/Client.php';
	require_once '../includes/function.php';
	
	$error = 0;
	if(isset($_POST['vname'])){
		$vname = $_POST['vname'];
	}else{
		$error++;
	}
	if(isset($_POST['vehicleno'])){
		$vehicleno = $_POST['vehicleno'];
	}else{
		$error++;
	}
	if(isset($_POST['imei'])){
		$imei = $_POST['imei'];
	}else{
		$error++;
	}
	if(isset($_POST['group'])){
		$group = $_POST['group'];
	}else{
		$error++;
	}
	if($error == 0){
		$getClient = Client::getClientbyImei($imei);
		if($getClient->rowCount() > 0){
			$_SESSION['errormsg'] = "Client already exists";
			redirect_to("../vehicle.php?m=err&imei=' . $imei");
		}else{
			$date = date("Y-m-d");
			$grp ='';
			foreach($_POST['group'] as $k => $value){
				$grp .= $value;
				if(count($_POST['group']) > ($k+1)){
					$grp .= ',';
				}
			}
	    	$query = "INSERT INTO `clients` (`g_id`,`imei`,`client_name`,`vehicleno`,`added`)
	    			VALUES ('{$grp}','{$imei}','{$vname}','{$vehicleno}','{$date}')
			    	";
	    	$sth = $connection->prepare($query);
	    	if($sth) {
		    	$sth->execute();
		    	$_SESSION['errormsg'] = 'New Client added successfully';
		    	redirect_to('../vehicle.php?m=comp');
	    	}else{
	    		$_SESSION['errormsg'] = 'Faild adding New Client';
	    		redirect_to('../vehicle.php?m=err&imei=' . $imei);
	    	}
		}
	}
?>