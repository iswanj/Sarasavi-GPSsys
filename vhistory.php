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
<link href="css/vhisto.css" rel="stylesheet" type="text/css" media="all">
<link href="css/antiscroll.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<!-- <script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=weather"></script> -->
<script src="js/iswanObj.js"></script>
<script src="js/jquery-1.7.2.js"></script>
<script src="js/jquery.tools.min.js"></script>
<script src="js/jquery-mousewheel.js"></script>
<script src="js/antiscroll.js"></script>
<script src="js/vhistory.js"></script>


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
        <a href="vhistory.php?vid=1&amp;vdate=<?php echo date("Y-m-d"); ?>" class="button" id="history">History</a>
        <a href="process/logout.php" class="button">Logout</a>
        <a href="users.php" class="button">Admin area</a>
    </div>
    <div id="clickable">Menu</div>
</div>
<input type="hidden" id="vid" value="<?php echo $_GET['vid']; ?>">
<input type="hidden" id="vdate" value="<?php echo $_GET['vdate']; ?>">
<div id="mymap"></div>
<div id="sidebar">
    <div class="sectionvehicle">
    	<h2>Watch history by date</h2>
        <form action="#" method="get" name="frmselectvh" id="frmselectvh" onchange="">
        	<label for="vid">Vehicle</label>
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
            <br><br>
            <label for="vdate">Date</label>
        	<select name="vdate"  class="" onChange="this.form.submit()">
            <?php 
				$curdate = date("Y-m-d");
			?>
            <option value="">Select a Date</option>
            	<?php 
					for($i=0; $i<10; $i++):
				?>
            	<option value="<?php echo date("Y-m-d", time() - 60 * 60 * 24 * $i); ?>" <?php if($_GET['vdate'] == date("Y-m-d", time() - 60 * 60 * 24 * $i)) echo 'selected'; ?>><?php echo date("Y-m-d", time() - 60 * 60 * 24 * $i); ?></option>
                
                <?php endfor; ?>
            </select>
            <br>
        </form>
    </div>
    <div class="vehicledetlist">
    	<div class="box-wrap antiscroll-wrap">
            <div class="box">
              <div class="antiscroll-inner">
            	<div class="box-inner">
                	<?php
                    	$all_location = Client::getAllClientLocations($_GET['vid'],$_GET['vdate']);
					?>
                  <table width="200" border="0" cellspacing="0" cellpadding="0">
                  	  <?php while($listlocation = $all_location->fetch(PDO::FETCH_ASSOC)): ?>
                      <?php 
					  		$timedata = explode(' ',$listlocation['date']);
					  ?>
                      <tr>
                        <td><?php echo $timedata[1]; ?></td>
                        <td><a href="#" onClick="placeMarker(<?php echo $listlocation['lat'] . ', ' .  $listlocation['lng']; ?>);"><?php echo $listlocation['lat'] . ', ' .  $listlocation['lng']; ?></a></td>
                      </tr>
                      <?php endwhile; ?>
                  </table>
            	</div>
              </div>
            </div>
          </div>
  </div>
</div>
<div id="overlay">
	
</div>
<div id="vehicalselect">

</div>
</body>
</html>
