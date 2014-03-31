<?php header("content-type:text/xml"); ?>
<?php 
	require_once '../includes/session.php';
	require_once '../includes/connection.php';
	require_once '../classes/Client.php';
	require_once '../classes/User.php';
?>
<locations xml:lang="EN">
<?php
	if(isset($_GET['vid']) && isset($_GET['vdate'])){
		$user = new User();
		$groupid = $user->userGroupId;
		$date = date("Y-m-d");
		$locations = Client::getClientbyId($_GET['vid']);
	        $timezone = "Asia/Colombo";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		$curtime = date("H:i:s");
		$list = $locations->fetch(PDO::FETCH_ASSOC);
		echo '<tracker>';
			echo '<imei>' . $list['imei'] . '</imei>';
			echo '<name>' . $list['client_name'] . '</name>';
			echo '<lat>' . $list['lat'] . '</lat>';
			echo '<lng>' . $list['lng'] . '</lng>';
			echo '<signal>' . $list['signal'] . '</signal>';
			echo '<cid>' . $list['imei'] . '</cid>';
			echo '<speed>' . $list['speed'] . '</speed>';
		echo '</tracker>';
		$all_location = Client::getAllClientLocations($_GET['vid'],$_GET['vdate']);
		echo '<locationsList>';
			while($listlocation = $all_location->fetch(PDO::FETCH_ASSOC)):
				if($listlocation['speed'] > 3){
					echo '<loc>';
						echo '<clat>' . $listlocation['lat'] . '</clat>';
						echo '<clng>' . $listlocation['lng'] . '</clng>';
						echo '<curspeed>' . $listlocation['speed'] . '</curspeed>';
						echo '<datetime>' . $listlocation['date'] . '</datetime>';
					echo '</loc>';
				}
			endwhile;
		echo '</locationsList>';
	}
?>
</locations>