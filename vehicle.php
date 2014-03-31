<?php 
	require_once 'includes/session.php';
	require_once 'includes/connection.php';
	require_once 'includes/function.php';
	require_once 'classes/User.php';
	require_once 'classes/Client.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Manage Vehicle</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" media="all">
<link href="css/users.css" rel="stylesheet" type="text/css" media="all">
<link href="css/showMessage.css" rel="stylesheet" type="text/css" media="all">
<link href="css/vehicle.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.showMessage.min.js"></script>
<script src = "js/jquery.validate.js"></script>
<script src="js/vehicle.js"></script>
</head>

<body>
<?php if($_SESSION['errormsg'] != '' && isset($_REQUEST['m'])): ?>
    <script type="text/javascript">
		$(function(){
			$('body').showMessage({
				thisMessage: ['<?php echo $_SESSION['errormsg']; ?>'],
				autoClose: true
			});
			return false;
		});
	</script>
<?php endif; ?>
<div id="wrapper">
  <div id="head">
  	<ul>
    	<li><a href="index.php">Live Map</a></li>
        <li><a href="#">Report</a></li>
        <li><a href="vhistory.php?vid=1&amp;vdate=<?php echo date("Y-m-d"); ?>">History</a></li>
        <li><a href="process/logout.php">Logout</a></li>
        <li><a href="users.php" class="cltxt">Users</a></li>
        <li><a href="vehicle.php" class="cltxt">Manage Vehicle</a></li>
        <li><a href="#" class="cltxt">Other</a></li>
        <li><a href="#" class="cltxt">Other</a></li>
        
    </ul>
  </div>
  <div id="main">
    <div id="left">
    	<div class="frmadduser">
        <h1>Manage Vehicle</h1>
        <form action="process/addvehicle.php" method="post" name="frmuser" id="frmuser">
    	  <table width="340" border="0" cellpadding="0" cellspacing="0">
    	    <tr>
    	      <th>Vehicle Name</th>
  	      </tr>
    	    <tr>
    	      <td><label for="vname"></label>
   	          <input name="vname" type="text" class="txt" id="vname" tabindex="10"></td>
  	      </tr>
    	    <tr>
    	      <th>Vehicle Number</th>
  	      </tr>
    	    <tr>
    	      <th><label for="vehicleno"></label>
   	          <input name="vehicleno" type="text" class="txt" id="vehicleno" tabindex="15"></th>
  	      </tr>
    	    <tr>
    	      <th>Imei</th>
  	      </tr>
    	    <tr>
    	      <td><label for="imei"></label>
   	          <input name="imei" type="text" class="txt" id="imei" tabindex="20" style="margin-bottom: 4px;" value="<?php if(isset($_GET['imei'])) echo $_GET['imei']; ?>">
   	          <br>
   	          Eg:- <span style="font-family:Arial, Helvetica, sans-serif; font-size: 11px;">imei:355689011882595</span></td>
  	      </tr>
    	    <tr>
    	      <th>Group</th>
  	      </tr>
    	    <tr>
    	      <td><label for="group"></label>
    	        <select name="group[]" multiple="multiple" size="10" class="txt" id="group" tabindex="50">
    	          <?php 
    	          	$getgroup = Client::getGroup();
    	          	while($fetchGr = $getgroup->fetch(PDO::FETCH_ASSOC)):
    	          ?>
    	          <option value="<?php echo $fetchGr['id']; ?>" <?php if($fetchGr['id'] == 1) echo "selected" ?>><?php echo $fetchGr['gname']; ?></option>
    	          <?php 
    	          	endwhile;
    	          ?>
              </select></td>
  	      </tr>
    	    <tr>
    	      <td><button class="button">Save</button></td>
  	      </tr>
  	      </table>
        </form>
        </div>
    </div>
    <div id="right">
    	<div class="usertable">
       	  <table width="457" border="0" cellpadding="0" cellspacing="0">
        	  <tr>
        	    <th width="114">Vehicle Name</th>
        	    <th width="114">Imei</th>
        	    <th width="191">Group</th>
        	    <th width="38">&nbsp;</th>
      	    </tr>
      	    <?php 
      	    	$getClientlist = Client::getClient();
      	    	while($fetchClient = $getClientlist->fetch(PDO::FETCH_ASSOC)):
      	    ?>
        	<tr>
        	    <td><?php echo $fetchClient['client_name']; ?></td>
        	    <td><?php echo $fetchClient['imei']; ?></td>
        	    <td>
        	    	<?php 
        	    		$getgroup = Client::getGroupbyId($fetchClient['g_id']);
        	    		$fecthgroup = $getgroup->fetch(PDO::FETCH_ASSOC);
        	    		echo $fecthgroup['gname'];
        	    	?>
        	   	</td>
        	    <td align="center"><a href="process/deletecl.php?delid=<?php echo $fetchClient['id']; ?>"><img src="images/Delete_user-32.png" width="16" height="16"></a></td>
      	    </tr>
      	    <?php 
      	    	endwhile;
      	    ?>
      	  </table>
        </div>
    </div>
  </div>
  <div id="footer">&copy; Copyright 2012 Sarasavi Publishers (pvt) Ltd.</div>
</div>
</body>
</html>