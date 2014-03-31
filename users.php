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
<title>Manage Users</title>
<link href="css/reset.css" rel="stylesheet" type="text/css" media="all">
<link href="css/users.css" rel="stylesheet" type="text/css" media="all">
<link href="css/showMessage.css" rel="stylesheet" type="text/css" media="all">
<script type="text/javascript" src="js/jquery-1.7.2.js"></script>
<script type="text/javascript" src="js/jquery.showMessage.min.js"></script>
<script src = "js/jquery.validate.js"></script>
<script src="js/user.js"></script>
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
        <h1>Manage Users</h1>
        <form action="process/addusers.php" method="post" name="frmuser" id="frmuser">
    	  <table width="340" border="0" cellpadding="0" cellspacing="0">
    	    <tr>
    	      <th><label for="fname">Full Name</label></th>
  	      </tr>
    	    <tr>
    	      <td>
   	          <input name="fname" type="text" class="txt" id="fname" tabindex="10"></td>
  	      </tr>
    	    <tr>
    	      <th><label for="username">Username</label></th>
  	      </tr>
    	    <tr>
    	      <td>
   	          <input name="username" type="text" class="txt" id="username" tabindex="20"></td>
  	      </tr>
    	    <tr>
    	      <th><label for="password">Password</label></th>
  	      </tr>
    	    <tr>
    	      <td>
   	          <input name="password" type="text" class="txt" id="password" tabindex="30"></td>
  	      </tr>
    	    <tr>
    	      <th><label for="cpassword">Confirm Password</label></th>
  	      </tr>
    	    <tr>
    	      <td>
   	          <input name="cpassword" type="text" class="txt" id="cpassword" tabindex="40"></td>
  	      </tr>
    	    <tr>
    	      <th><label for="group">Group</label></th>
  	      </tr>
    	    <tr>
    	      <td>
    	        <select name="group" size="10" class="txt" id="group" tabindex="50">
    	          <?php 
    	          	$getgroup = Client::getGroup();
    	          	while($fetchGr = $getgroup->fetch(PDO::FETCH_ASSOC)):
    	          ?>
    	          <option value="<?php echo $fetchGr['id']; ?>"><?php echo $fetchGr['gname']; ?></option>
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
        	    <th width="114">Full Name</th>
        	    <th width="114">Username</th>
        	    <th width="191">Group</th>
        	    <th width="38">&nbsp;</th>
      	    </tr>
            <?php 
				$user = new User();
				$userlist = $user->getUser();
				while($fetchuser = $userlist->fetch(PDO::FETCH_ASSOC)):
			?>
        	  <tr>
        	    <td><?php echo $fetchuser['fullname']; ?></td>
        	    <td><?php echo $fetchuser['username']; ?></td>
        	    <td>
        	    	<?php 
        	    		$getgroup = Client::getGroupbyId($fetchuser['group']);
        	    		$fecthgroup = $getgroup->fetch(PDO::FETCH_ASSOC);
        	    		echo $fecthgroup['gname'];
        	    	?>
        	    </td>
        	    <td align="center"><a href="process/deleteuser.php?delid=<?php echo $fetchuser['id']; ?>"><img src="images/Delete_user-32.png" width="16" height="16"></a></td>
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