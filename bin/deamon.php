<?php
	ob_implicit_flush();
	require_once '../includes/session.php'; 
	require_once '../includes/connection.php';
	require_once '../classes/logfile.php';
	require_once '../classes/Tracker.php';
?>
<?php

/////////////////////////////////////////////////////////
$address = '192.168.1.225'; // IP Address
$port=9000; //Port

$sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));

if($sock == FALSE){
	echo "Socket create fails";
}else{
	socket_bind($sock, $address, $port) or die ("cannot bind to address.");
	echo socket_strerror(socket_last_error());
	socket_listen($sock,20);
	//$scc = socket_create_listen($sock,20);
	//socket_set_nonblock($scc);

}

$i=0;
while(1){
	$result = $client[++$i] = socket_accept($sock);
	if($result !== FALSE):
		//socket_write($client[$i], "Socket Accepted" , 1024000);
		$input = socket_read($client[$i], 1024000);
		if($input !== FALSE){
			$data = 'Thank you for your request!' . " \r\n";
			socket_write($client[$i], $data, 1024000);
			
			socket_write($client[$i], $input , 1024000);
			//$finInput = mysql_prep($input);
			$finInput = $input;
			//$input = preg_replace('/\?\//', '?', $input);
			echo $finInput . "\r\n";
			
			$lf = new Logfile();
			$lf->write($finInput);
			
			$tracker = new Tracker();
			// split client request database
			//$data = '1204270959,��e}��}��̖w���e,GPRMC,095929.000,A,0652.2527,N,07953.3028,E,0.53,219.64,270412,,,A*6E,F,imei:355689011882595,112+�';
			$data_array = $tracker->splitdata($finInput);
                        $newloc = array();
                        if(count($data_array) >7){
                            $location = $tracker->getlatlng($data_array[5], $data_array[7]);
                            $newloc['imei'] = $data_array[16];
                            $newloc['signal'] = $data_array[15];
                            $newloc['speed'] = $data_array[9];
                        }else{
                            $spbyhash = $tracker->splitdataHash($data_array[0]);
                            $location = $tracker->getlatlng($data_array[2], $spbyhash[8]);
                            echo $newloc['imei'] = 'imei:'.$spbyhash[1];
                            $newloc['signal'] = 0;
                            $newloc['speed'] = $data_array[4];
                        }
			
			
			$newloc['lat'] = $location['lat'];
			$newloc['lng'] = $location['lng'];
			$tracker->addlocation($newloc);
			echo "\r\n";
			//print_r($newloc);
			socket_close($client[$i]);
		}else{
			echo "socket_read() failed: reason: " . socket_strerror(socket_last_error($input)) . "\n";
            socket_close($client[$i]);
		}
		
	else:
		echo "Socket Accept faild";
		socket_write($client[$i], "Socket Accept faild" , 1024000);
		socket_close($client[$i]);
	endif;
}
socket_close($sock);
?>
