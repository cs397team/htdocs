<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.1/jquery.min.js"></script>-->
<script type="text/javascript" src="anim_navbar.js"></script>
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>R3 Reservations</title>
</head>

<body>
<div id="wrap">

<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" style="padding-right:30px;"/>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<div class="container" id="navbar">
	<ul id="sprite">
	<li id="b0" class="a0"><a class="navlink" href="member-index.php">Home</a></li>
	<li id="b1"><a class="navlink" href="reservations.php">Approved Reservations</a></li>
	<li id="b2"><a class="navlink" href="pending.php">Pending Reservations</a></li>
	<li id="b3"><a class="navlink" href="searchByDate.php">Reserve</a></li>
	<li id="b4" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>

<div id="content" style="padding-top:100px;">


<?php
    if($_SERVER['SERVER_PORT'] != '443') 
    { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    }
    
    //Start session
	session_start();
	
	//Check whether the session variable SESS_MEMBER_ID is present or not
	if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) {
		echo "<h2 align=\"center\">Hey, you're not logged in!!!!</h2>";
        echo "<h2 align=\"center\">Click <a href=\"login.php\">here</a> to get logged in.</h2>";
		exit();
	}
    else if($_SESSION['SESS_ISADMIN'] == 1)
    {
        //If the admin trys to access the normal member-index, just forward him to his own index
        header("location: admin-index.php");
    }
    
    echo "<h2 align=\"center\">Welcome back to the system, ".$_SESSION['SESS_NAME']."!</h2>";
?>

<!--
<p>
<table border='1'>
<tr><td>
<h3>Menu</h3>
</td></tr>

<tr><td>
<a href="reservations.php">Approved Reservations</a>
</td></tr>

<tr><td>
<a href="pending.php">Pending Reservations</a>
</td></tr>

<tr><td>
<a href="searchByDate.php">Search for Room by Date</a>
</td></tr>

<tr><td>
<a href="addUser.php">Add a User</a>
</td></tr>

<tr><td>
<a href="reserve.php">Freakishly Long/Incomplete Form</a>
</td></tr>
</table>
</p>

<p>Click <a href="logout.php">here</a> to logout.</p>
-->

</div>
</div>
</body>
</html>
