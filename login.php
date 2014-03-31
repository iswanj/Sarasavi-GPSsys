<?php 
	require_once 'includes/session.php';
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Sarasavi Publication | Login</title>
<link rel="shortcut icon" href="favicon.ico" />
<script type="text/javascript" src="../jq/jquery-1.4.4.js"></script>

<style type="text/css">
body {
	background-image: url(images/bg.jpg);
	background-repeat: repeat-x;
	margin: 0;
	background-position: left -5px;
}
#showover {
	display: none;
	background-color: rgba(255,255,255,.6);
	height: 100%;
	width: 100%;
	position: absolute;
	margin: 0px;
	top: 0px;
	background-repeat: no-repeat;
	background-position: 50% 50%;
}
#underconstruction {
	width: 500px;
	margin-right: auto;
	margin-left: auto;
	margin-bottom: 0px;
	margin-top: 0px;
	text-align: center;
	display: block;
	position: relative;
}
#loginform table {
	margin: 0 auto;
}
#loginform table tr td {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #333;
	padding: 5px;
}
input[type=text] , input[type=password]{
	border: 1px solid #999;
	height: 20px;
	width: 200px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}

input[type=submit] {
	background: -moz-linear-gradient(
		top,
		#dddedf 0%,
		#c1c3c5);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#dddedf),
		to(#c1c3c5));
	color: #333;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 13px;
	cursor: pointer;
	cursor: hand;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	padding-top: 6px;
	padding-right: 14px;
	padding-bottom: 6px;
	padding-left: 14px;
	font-weight: normal;
}
#submit:hover{
	background: -moz-linear-gradient(
		top,
		#dddedf 0%,
		#c1c3c5);
	background: -webkit-gradient(
		linear, left top, left bottom, 
		from(#dddedf),
		to(#c1c3c5));
}
#underconstruction #login_error {
	font-family: Verdana, Geneva, sans-serif;
	font-size: 12px;
	color: #F00;
	font-weight: bold;
	text-align: center;
	display: none;
	padding: 4px;
	margin-right: 6em;
	margin-left: 6em;
	background-color: #FC0;
	border: 1px solid #F00;
}
#underconstruction #logo {
	background-image: url(images/logo.jpg);
	background-position: center 110px;
	background-repeat: no-repeat;
}
#errmessage {
	background-color: rgba(255,255,204,1);
	border: 2px solid rgba(204,51,0,1);
	min-height: 20px;
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	font-weight: bold;
	color: rgba(255,0,0,1);
	padding-top: 8px;
	padding-right: 6px;
	padding-bottom: 8px;
	padding-left: 6px;
}
</style>
<script type="text/javascript" src="../jq/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="../jq/fancybox/jquery.fancybox-1.3.4.css" media="screen" />
<script type="text/javascript" src="js/login.js"></script>
</head>

<body>
<div id="showover"></div>
<section id="underconstruction">
  <section id="logo" style="height: 200px;"></section>
    	<?php 
		if(isset($_SESSION['error_msg']) && $_SESSION['error_msg'] != '') {
			echo '<div id="errmessage">' . $_SESSION['error_msg'] . '<div>';
		}
		?>
    <form action="process/prologin.php" method="post" name="loginform" id="loginform">
      <table style="width: 296px; border-collapse: collapse; border: none;">
        <tr>
          <td align="right" valign="middle" nowrap><label for="username">Username : &nbsp;</label></td>
          <td valign="middle">
          <input type="text" name="username" id="username" tabindex="10" placeholder=" eg: yourname@sarasavi.lk"></td>
        </tr>
        <tr>
          <td align="right" valign="middle" nowrap><label for="password">Password : &nbsp;</label></td>
          <td valign="middle">
          <input type="password" name="password" id="password" tabindex="20" placeholder=" Type your password here"></td>
        </tr>
        <tr>
          <td align="right" valign="middle"></td>
          <td align="left" valign="middle"><input type="submit" name="submit" id="submit" value="login"></td>
        </tr>
      </table>
    </form>
</section>
</body>
</html>