<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>R3 Homepage</title>
</head>

<body>
<div id="wrap">
<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" style="padding-right:30px;" />
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<hr />
<h2 align="center">Welcome to R<sup>3</sup> Room Reservation System!</h2>

<?php
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

//Start session
session_start();
	
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) {
	echo "<p align=\"center\"> You are currently not logged in. </p>";
    echo "<p align=\"center\"> Click <a href=\"login.php\">here</a> to get logged in and access the rest of the system. </p>";
} else {
    echo "<p align=\"center\"> You are currently logged in </p>";
    echo "<p align=\"center\"> Click <a href=\"member-index.php\">here</a> to go to the member area. </p>";
    echo "<p align=\"center\"> Click <a href=\"logout.php\">here</a> to logout. </p>";
}
?>
</body>
</html>
