<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
    unset($_SESSION['SESS_STUDENT_ID']);
    unset($_SESSION['SESS_NAME']);
    unset($_SESSION['SESS_ISADMIN']);
    unset($_SESSION['SESS_EMAIL']);
	
?>

<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<html>
<head>
<title>Logout of the R3 System</title>
</head>

<body>
<div id="wrap">
<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" />
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">

<div id="content">
<hr />
<h2>Logout of the R3 System</h2>
<p>&nbsp;</p>
<h4 class="err">You have been logged out.</h4>
<p>Click here to <a href="login.php">Login</a></p>
</div>

</div>
</body>
</html>