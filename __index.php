<?php 
	require_once 'includes/session.php';
	require_once 'includes/connection.php';
	require_once 'classes/Client.php';
	require_once 'classes/User.php';
	require_once 'includes/function.php';

	if(!isset($_SESSION['user_id'])){
		redirect_to('login.php');
	}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Sarasavi GPS System</title>
<link href="css/reset.css" rel="stylesheet" type="text/css">
<link href="css/default.css" rel="stylesheet" type="text/css">
<link href="css/antiscroll.css" rel="stylesheet">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=weather"></script> -->
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<script src="js/jquery-mousewheel.js"></script>
<script src="js/antiscroll.js"></script>
<script src="js/home.js"></script>
</head>

<body>
<?php
	$user = new User();
	$groupid = $user->userGroupId;
?>
<div id="navhover">
	<div id="navigation">
    	<a href="index.php" class="button">Live Map</a>
        <a href="#" class="button">Report</a>
        <a href="vhistory.php?vid=1&amp;vdate=<?php echo date("Y-m-d"); ?>" class="button" id="history" >History</a>
        <a href="process/logout.php" class="button">Logout</a>
        <a href="users.php" class="button">Admin area</a>
    </div>
    <div id="clickable">Menu</div>
</div>
<div id="mymap"></div>
<div id="sidebar">
    <div class="sectionvehicle">
    	<h2>Available Vehicle List</h2>
        <div class="box-wrap antiscroll-wrap">
            <div class="box">
              <div class="antiscroll-inner">
            	<div class="box-inner">
                <ul>
                    <?php
                        $getclientlist = Client::getClientbyGid($groupid);
                        while($clientlist = $getclientlist->fetch(PDO::FETCH_ASSOC)):
                    ?>
                    <li><a href="currentvehicle.php?vid=<?php echo $clientlist['id']; ?>" id="<?php echo $clientlist['id']; ?>"><?php echo $clientlist['client_name'] . ' - ' . $clientlist['vehicleno']; ?></a><button class="btncenter button2" id="<?php echo $clientlist['id']; ?>" onclick="mapcenterbyclient(<?php echo $clientlist['lat'] . ',' . $clientlist['lng']; ?>)">Center</button></li>
                    <?php 
                        endwhile;
                    ?>
                </ul>
                </div>
              </div>
            </div>
          </div>
		<div class="labeldiv" style="text-align: center; margin-top: 1em;">
    		<img src="images/label.png" >
    	</div>
	</div>
</div>
<div id="overlay">
	
</div>
<div id="vehicalselect">
<ul>
	
</ul>
</div>
</body>
<?php 
	unset($user);
?>
</html>
