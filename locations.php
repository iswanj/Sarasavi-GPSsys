<?php header("content-type:text/xml"); ?>
<?php 
	require_once '../includes/session.php';
	require_once '../classes/db.php';
	require_once '../classes/Tracker.php'
?>
<locations xml:lang="EN">
<?php
	$db = new Db('localhost', 'root', '', 'gpssys');
	$connection = $db->open();
	
	$tracker = new Tracker();
	$locations = $tracker->getTrackers();
        $timezone = "Asia/Colombo";
	if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
	$curtime = date("H:i:s");
	while($list = $locations->fetch(PDO::FETCH_ASSOC)){		
		echo '<tracker>';
			echo '<imei>' . $list['imei'] . '</imei>';
			echo '<name>' . $list['client_name'] . '</name>';
			echo '<lat>' . $list['lat'] . '</lat>';
			echo '<lng>' . $list['lng'] . '</lng>';
			echo '<signal>' . $list['signal'] . '</signal>';
			echo '<cid>' . $list['imei'] . '</cid>';
                        echo '<time>' . $curtime . '</time>';
		echo '</tracker>';
	}
	
?>
</locations>