<?php header("content-type:text/xml"); ?>
<?php 
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../classes/Client.php';
	require_once '../classes/User.php';
?>
<locations xml:lang="EN">
<?php
	$user = new User();
	$groupid = $user->userGroupId;
	$locations = Client::getClientbyGid($groupid);
        $timezone = "Asia/Colombo";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$curtime = date("H:i:s");
	$curdate = date("Y-m-d");
	while($list = $locations->fetch(PDO::FETCH_ASSOC)){
		$getlocbyclid = Client::getlocbyclid($list['id']);
		$lastuptime = NULL;
		$ldate = NULL;
		$ltime = NULL;
		$i=1;
		while($fetchloc = $getlocbyclid->fetch(PDO::FETCH_ASSOC)):
			if($i >= $getlocbyclid->rowCount()){
				$lastuptime = explode(' ', $fetchloc['date']);
				$ldate = $lastuptime[0];
				$ltime = $lastuptime[1];
			}
		$i++;
		endwhile;
		echo '<tracker>';
			echo '<imei>' . $list['imei'] . '</imei>';
			echo '<name>' . $list['client_name'] . '</name>';
			echo '<lat>' . $list['lat'] . '</lat>';
			echo '<lng>' . $list['lng'] . '</lng>';
			echo '<signal>' . $list['signal'] . '</signal>';
			echo '<cid>' . $list['imei'] . '</cid>';
			echo '<speed>' . $list['speed'] . '</speed>';
			echo '<lastspeed>' . $list['lastspeed'] . '</lastspeed>';
			echo '<ctime>' . $curtime . '</ctime>';
			echo '<timediff>' . round(abs($curtime - $ltime) / 60,2) . " minute" . '</timediff>';
			if($ldate == $curdate){
				echo '<lastrupdate>1</lastrupdate>';
			}else{
				echo '<lastrupdate>0</lastrupdate>';
			}
		echo '</tracker>';
	}
	
?>
</locations>