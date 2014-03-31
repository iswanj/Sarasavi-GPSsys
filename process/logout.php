<?php if(!ob_start()) { ob_start(); } ?>
<?php
	require_once '../includes/session.php';
	require_once '../includes/function.php';
?>
<?php 
	unset($_SESSION['user_id']);
	unset($_SESSION['userfname']);
	unset($_SESSION['error_msg']);
	unset($_SESSION['usergroup']);
	redirect_to('../login.php');
?>