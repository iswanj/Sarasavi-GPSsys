<?php 
	require_once '../includes/session.php'; 
	require_once '../includes/connection.php';
	require_once '../classes/logfile.php';
	require_once '../classes/Tracker.php';
	
	$tracker = new Tracker();
	
	$GetLoc = $tracker->getLocations();
	//date
	$curDate = date("Y-m-d");
	function dateDiff ($d1, $d2) {
		// Return the number of days between the two dates:
	
		return round(abs(strtotime($d1)-strtotime($d2))/86400);
	
	}  // end function dateDiff
	while($getFetch = $GetLoc->fetch(PDO::FETCH_ASSOC)):
		$getDate = $getFetch['date'];
		$datearray = explode(' ',$getDate);
		$getdateonly = $datearray[0];
		$datediff = dateDiff($curDate,$getdateonly);
		if($datediff > 60 ){
			$deltracker = $tracker->deleteLocation($getFetch['l_id']);
			if($deltracker == 1){
				exit;
			}else{
				exit;
			}
		}
	endwhile;
	
	
?>