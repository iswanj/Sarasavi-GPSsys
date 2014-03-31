<?php
require_once 'Client.php';
class Tracker {
	/*public static function getClientbyImei($imei){
		global $connection;
		$query = "SELECT *
				FROM `clients`
				WHERE `imei` = '{$imei}'
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else die('Get Client by IMEI: select prepare returned no statement handle');
		return $sth;
	}*/
	public $spstatus = 0;
	//public $last_speed = 0;
	public static function GetClientLastSpeed($imei){
		global $connection;
		$query = "SELECT *
				FROM `clients`
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else $_SESSION['global_error'] = ('get Trackers: select prepare returned no statement handle');
		return $sth;
	}
	public function addlocation($data){
		global $connection;
		$acspeed = $data['speed'] * 1.852;
		/*if($acspeed<3){
			$this->spstatus = 1;
		}else{
			$this->spstatus = 0;
		}*/
		$getlspeed = Tracker::GetClientLastSpeed($data['imei']);
		$fetchlspeed = $getlspeed->fetch(PDO::FETCH_ASSOC);
		//$this->last_speed = $fetchlspeed['lastspeed'];
		$timezone = "Asia/Colombo";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		if($this->spstatus == 0){
			$query = "UPDATE `clients`
						SET `lat` = '{$data['lat']}',
						`lng` = '{$data['lng']}',
						`signal` = '{$data['signal']}',
						`speed` = '{$acspeed}',
						`lastspeed` = {$fetchlspeed['lastspeed']}
						WHERE `imei` = '{$data['imei']}';
						";
			$sth = $connection->prepare($query);
			if($sth) {
				$sth->execute();
				$_SESSION['global_error'] = '';
			}
			else {die('add location: select prepare returned no statement handle');}
		}
		$getclient = Client::getClientbyImei($data['imei']);
		$listclientdet = $getclient->fetch(PDO::FETCH_ASSOC);
		$timezone = "Asia/Colombo";
		if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);
		
		if($this->spstatus == 0){
			$query1 = "INSERT INTO `location` (`c_id`,`lat`,`lng`,`speed`)
			VALUES ({$listclientdet['id']},{$data['lat']},{$data['lng']},{$data['speed']})
			";
			$sth1 = $connection->prepare($query1);
			if($sth1){
			$sth1->execute();
				$_SESSION['global_error'] = '';
			}else die('Add Location: Select prepare returned no statement handle');
		}
		
		//return $sth1;
	}
	
	public static function split_on($string, $num) {
		$length = strlen($string);
		$output[0] = substr($string, 0, $num);
		$output[1] = substr($string, $num, $length );
		return $output;
	}
	
	public function getlatlng($lat,$lng){
		$latAr = Tracker::split_on($lat, 2);
		$lngAr = Tracker::split_on($lng, 3);
		
		$latitude = $latAr[0] + ($latAr[1]/60);
		$longitude = $lngAr[0] + ($lngAr[1]/60);
		$locationAr['lat'] = $latitude;
		$locationAr['lng'] = $longitude;
		
		return $locationAr;
	}
	public function splitdata($data){
		return explode(',',$data);
	}
        public function splitdataHash($data){
            return explode('#',$data);
        }
	
	public function getTrackers(){
		global $connection;
		$query = "SELECT *
				FROM `clients`
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else $_SESSION['global_error'] = ('get Trackers: select prepare returned no statement handle');
		return $sth;
	}
	public function getLocations(){
		global $connection;
		$query = "SELECT *
				FROM `location`
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			$_SESSION['global_error'] = '';
		}
		else $_SESSION['global_error'] = ('get Trackers: select prepare returned no statement handle');
		return $sth;
	}
	public function deleteLocation($id){
		global $connection;
		$query = "DELETE
				FROM `location`
				WHERE `l_id` = {$id}
				";
		$sth = $connection->prepare($query);
		if($sth) {
			$sth->execute();
			return 1;
		}
		else return 0;
	}
}

?>
