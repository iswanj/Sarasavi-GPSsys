<?php 
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../classes/User.php';
	require_once '../includes/function.php';
	$error = 0;
	if(isset($_POST['fname'])){
		$fname = $_POST['fname'];
	}else{
		$error++;
	}
	if(isset($_POST['username'])){
		$username = $_POST['username'];
	}else{
		$error++;
	}
	if(isset($_POST['password'])){
		$password = $_POST['password'];
	}else{
		$error++;
	}
	if(isset($_POST['cpassword'])){
		$cpassword = $_POST['cpassword'];
	}else{
		$error++;
	}
	if(isset($_POST['group'])){
		$group = $_POST['group'];
	}else{
		$error++;
	}
	
	if($error == 0){
		$user = new User();
		$userlist = $user->getUserbyUname($username);
		if($userlist->rowCount() != 1){
			if($password != $cpassword){
				$_SESSION['errormsg'] = "Password matching faild..";
				redirect_to("../users.php?m=err");
				//redirect to form
			}else{
				$adduser = $user->addUser($fname, $username, $password, $group);
				if($adduser){
					$_SESSION['errormsg'] = "user has been added successfully";
					//redirect to form
					redirect_to("../users.php?m=err");
				}else{
					$_SESSION['errormsg'] = "User adding faild";
					//redirect to form
					redirect_to("../users.php?m=err");
				}
			}
		}else{
			// Username already exists
			$_SESSION['errormsg'] = "Username or password is incorrect";
			//redirect to form
			redirect_to("../users.php?m=err");
		}
	}
	
	
	
	
?>