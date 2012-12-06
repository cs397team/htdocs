<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>R3 Admin Area</title>
</head>

<body>
<div id="wrap">

<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<div class="container" id="navbar">
	<ul id="anim">
	<li id="b0" class="a0"><a class="navlink" href="admin-index.php">Home</a></li>
	<li id="b1"><a class="navlink" href="viewPending.php">Pending Reservations</a></li>
	<li id="b2"><a class="navlink" href="viewAccepted.php">Accepted Reservations</a></li>
	<li id="b3"><a class="navlink" href="viewDenied.php">Denied Reservations</a></li>
	<li id="b4" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>

<div id="content" align="center" style="padding-top:100px;">

<?php
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

//Start session
session_start();
	
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) {
	header("location: login.php");
}
else if($_SESSION['SESS_ISADMIN'] == 0)
{
    header("location: index.php");
    
	exit();
}

echo "<h2 align=\"center\">Welcome back to the Admin Area, ".$_SESSION['SESS_NAME']."!</h2>";
?>
	
</br>
<p>Search For Event by Title or ID#</p>
<form action=searchForEvent.php method = "post">
	<input type = "text" name = "searchName" style="width:200px; height:32px; font-size:22px;" />
</form>

</body>
</html>
