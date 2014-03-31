<?php
	require_once 'includes/session.php'; 
	require_once 'includes/connection.php';
	require_once 'classes/logfile.php';
	require_once 'classes/Tracker.php';
?>
<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$data = '#356823033286522##0#0000#AUT#1#V#07954.7732,E,0651.3192,N,018.8,115#200313#051039##';
$data2 = '1204270959,��e}��}��̖w���e,GPRMC,095929.000,A,0652.2527,N,07953.3028,E,0.53,219.64,270412,,,A*6E,F,imei:355689011882595,112+�';
$tracker = new Tracker();

$data_array = $tracker->splitdata($data);
$data_array2 = $tracker->splitdata($data2);
print_r($data_array);
echo '<br>';
print_r($data_array2);
echo '<br>';
$splitbyhash = $tracker->splitdataHash($data_array[0]);
print_r($splitbyhash);
echo '<br>';
echo 'imei:'.$splitbyhash[1];
?>