<?php
	// session start$_SESSION['errormsg']
	session_start();
	if(!isset($_SESSION['global_error'])){
		$_SESSION['global_error'] = '';
	}
	if(!isset($_SESSION['errormsg'])){
		$_SESSION['errormsg'] = '';
	}
	
	$_SESSION['userid'] = 1;
?>