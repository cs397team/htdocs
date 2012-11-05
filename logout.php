<?php
	//Start session
	session_start();
	
	//Unset the variables stored in session
    unset($_SESSION['SESS_STUDENT_ID']);
    unset($_SESSION['SESS_NAME']);
    unset($_SESSION['SESS_ISADMIN']);
    unset($_SESSION['SESS_EMAIL']);
	
    ?>

<html>
<head>
<title>Logout of the R3 System</title>
</head>

<body bgcolor = "black" link = "white" vlink = "white" text="white">

<div align="center">

<h1 align="center" >Logout of the R3 System</h1>
<hr />
<p align="center">&nbsp;</p>
<h4 align="center" class="err">You have been logged out.</h4>
<p align="center">Click here to <a href="login.php">Login</a></p>
</body>
</html>