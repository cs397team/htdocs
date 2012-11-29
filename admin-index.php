<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Admin Area</title>
</head>

<body>
<div id="wrap">
<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" style="padding-right:30px;" />
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<hr />
<h2 align="center" >Administrator Area</h2>

<div align="center">

<?php
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

//Start session
session_start();
	
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) {
	echo "<p align=\"center\"> Hey, you're not logged in!!!! </p>";
    echo "<p align=\"center\"> Click <a href=\"login.php\">here</a> to get logged in. </p>";
	exit();
}
else if($_SESSION['SESS_ISADMIN'] == 0)
{
    echo "<p>You are trying to access the Admin Page<br>";
	echo "You are NOT an Admin!</p>";
	exit();
}
?>
	


<form action=viewPending.php method = "post">
	<input type = "submit" name = "viewPending" style="width:200px; height:32px; font-size:22px;" value = "View Pending" /><br>
</form>
<form action=viewAccepted.php method = "post">
	<input type = "submit" name = "viewAccepted" style="width:200px; height:32px; font-size:22px;" value = "View Accepted" /><br>
</form>
<form action=viewDenied.php method = "post">
	<input type = "submit" name = "viewDenied" style="width:200px; height:32px; font-size:22px;" value = "View Denied" />
</form>
Search For Event
<form action=searchForEvent.php method = "post">
	<input type = "text" name = "searchName" style="width:200px; height:32px; font-size:22px;" />
</form>

<p>Click <a href="logout.php">here</a> to logout.</p>

</body>
</html>
