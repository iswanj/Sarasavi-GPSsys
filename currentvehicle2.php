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
<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0">
<link href="css/reset.css" rel="stylesheet">
<link href="css/default.css" rel="stylesheet">
<link href="css/curvh.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=weather"></script> -->
<script src="js/iswanObj.js"></script>
<script src="js/jquery-1.7.2.js"></script>
<script src="js/jquery.tools.min.js"></script>
<script src="js/curvehicle.js"></script>
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
    </div>
    <div id="clickable">Menu</div>
</div>
<input type="hidden" id="vid" value="<?php echo $_GET['vid']; ?>">
<div id="mymap"></div>
<div id="sidebar">
    <div class="sectionvehicle">
    	<h2>Avbailable Vehicle List</h2>
        <form action="#" method="get" name="frmselectvh" id="frmselectvh" onchange="">
        	<select name="vid" class="" onChange="this.form.submit()">
            <option value="">Select a Vehicle</option>
            <?php
				$getclientlist = Client::getClientbyGid($groupid);
				while($clientlist = $getclientlist->fetch(PDO::FETCH_ASSOC)):
			?>
            	<option value="<?php echo $clientlist['id']; ?>" <?php if($_GET['vid'] == $clientlist['id']) echo 'selected' ?>><?php echo $clientlist['client_name']; ?></option>
            <?php 
				endwhile;
			?>
            </select>
        </form>
    </div>
    <div class="vehicledetlist">
    	<table width="227" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <th width="77">IMEI</th>
            <td width="150"><span id="vimei"></span></td>
          </tr>
          <tr>
            <th>Lat	</th>
            <td><span id="vlat"></span></td>
          </tr>
          <tr>
            <th>Lng</th>
            <td><span id="vlng"></span></td>
          </tr>
          <tr>
            <th>Speed</th>
            <td><span id="vspeed"></span></td>
          </tr>
          <tr>
            <th>Signal</th>
            <td><span id="vsignal"></span></td>
          </tr>
        </table>
  </div>
</div>
<div id="overlay">
	
</div>
<div id="vehicalselect">

</div>
</body>
</html>
