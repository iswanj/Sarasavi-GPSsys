<?php 
	//require_once '../classes/logfile.php';

?>
<?php

/////////////////////////////////////////////////////////

/////////////////////////////////////////////////////////
$address = '192.168.1.225'; // IP Address
$port=9001; //Port

$sock = socket_create(AF_INET, SOCK_STREAM, getprotobyname('tcp'));
socket_bind($sock, $address, $port) or die ("cannot bind to address.");
echo socket_strerror(socket_last_error());
socket_listen($sock,10);
$i=0;
while(1){
	$result = $client[++$i] = socket_accept($sock);
	$input = socket_read($client[$i], 1024);

	if($result):
		$data = 'Thank you for your request!' . " \r\n";
		socket_write($client[$i], $data, 1024);
	endif;

	socket_write($client[$i], $input , 1024);
	//$finInput = mysql_prep($input);
	$finInput = $input;
	//$input = preg_replace('/\?\//', '?', $input);
	echo $finInput . "\r\n";
	
	
	socket_close($client[$i]);
}
socket_close($sock);
?>
