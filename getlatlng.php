<?php require_once 'classes/Tracker.php'; ?>
<?php
	//$data = '1204270959,Éîe}…Í}äÞÌ–wäŸÕíe,GPRMC,095929.000,A,0652.2527,N,07953.3028,E,0.53,219.64,270412,,,A*6E,F,imei:355689011882595,112+ä';
	$data ='1204270959,Éîe}…Í}äÞÌ–wäŸÕíe,GPRMC,095929.000,A,0652.2527,N,07953.3028,E,0.53,219.64,270412,,,A*6E,F,imei:355689011882595,112+ä';
	$tracker = new Tracker();
	$data_array = $tracker->splitdata($data);
	print_r($data_array);
	$location = $tracker->getlatlng($data_array[5], $data_array[7]);
	
	print_r($location);
?>