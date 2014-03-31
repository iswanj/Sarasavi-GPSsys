<?php  
	require_once '../includes/session.php'; 
	require_once '../includes/connection.php';
	require_once '../classes/logfile.php';
	require_once '../classes/Tracker.php';
?>
<?php

/////////////////////////////////////////////////////////
function mysql_prep( $value ){
	$magic_quotes_active = get_magic_quotes_gpc();
	$new_enough_php = function_exists( "mysql_real_escape_string" ); // i.e. PHP >= v4.3.0
	if( $new_enough_php ) { // PHP v4.3.0 or higher
		// undo any magic quote effects so mysql_real_escape_string can do the work
		if( $magic_quotes_active ) {
			$value = stripslashes( $value );
		}
		$value = mysql_real_escape_string( $value );
	} else { // before PHP v4.3.0
		// if magic quotes aren't already on then add slashes manually
		if( !$magic_quotes_active ) {
			$value = addslashes( $value );
		}
		// if magic quotes are active, then the slashes already exist
	}
	return $value;
}
/////////////////////////////////////////////////////////
$address = '192.168.1.225'; // IP Address
$port=9000; //Port

$sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
socket_bind($sock, $address, $port) or die ("cannot bind to address.");
echo socket_strerror(socket_last_error());
socket_listen($sock,20);
$i=0;
while(1){
	$result = $client[++$i] = socket_accept($sock);
	$input = socket_read($client[$i], 1024000);

	if($result):
		$data = 'Thank you for your request!' . " \r\n";
		socket_write($client[$i], $data, 1024000);
	else:
		$data = 'Try agian!' . " \r\n";
		socket_write($client[$i], $data, 1024000);
	endif;

	socket_write($client[$i], $input , 1024000);
	//$finInput = mysql_prep($input);
	$finInput = $input;
	//$input = preg_replace('/\?\//', '?', $input);
	echo $finInput . "\r\n";
	
	$lf = new Logfile();
	$lf->write($finInput);
	
	$tracker = new Tracker();
	// split client request database
	//$data = '1204270959,Éîe}…Í}äÞÌ–wäŸÕíe,GPRMC,095929.000,A,0652.2527,N,07953.3028,E,0.53,219.64,270412,,,A*6E,F,imei:355689011882595,112+ä';
	$data_array = $tracker->splitdata($finInput);
	$location = $tracker->getlatlng($data_array[5], $data_array[7]);
	
	$newloc = array();
	
	$newloc['lat'] = $location['lat'];
	$newloc['lng'] = $location['lng'];
	$newloc['imei'] = $data_array[16];
	$newloc['signal'] = $data_array[15];
	$newloc['speed'] = $data_array[9];
	$tracker->addlocation($newloc);
	echo "\r\n";
	print_r($newloc);
	
	socket_close($client[$i]);
}
socket_close($sock);
?>
