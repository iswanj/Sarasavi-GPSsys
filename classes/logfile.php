<?php
class Logfile{
	public function write($the_string )
	{
		if( $fh = @fopen( "../log/log.txt", "a+" ) ){
			$value = $the_string . "\r\n";
			fputs( $fh, $value, strlen($value) );
			fclose( $fh );
			return( true );
		}
		else{
			return( false );
		}
	}
}
?>