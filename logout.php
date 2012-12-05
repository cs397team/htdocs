<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Logout of the R3 System</title>
</head>

<body>
<div id="wrap">
<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<hr />

<div id="content" style="padding-top:50px;">
<h3 align="center">You have been logged out.</h3>
<p align="center">Click here to <a href="login.php">Login</a></p>
</div>

<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
    unset($_SESSION['SESS_STUDENT_ID']);
    unset($_SESSION['SESS_NAME']);
    unset($_SESSION['SESS_ISADMIN']);
    unset($_SESSION['SESS_EMAIL']);
	
?>


</div>
</body>
</html>