<html>
<html>
<head>
<title>Admin Area</title>
</head>

<body bgcolor = "black" link = "white" vlink = "white" text="white">

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
	echo "<p>Hey, you're not logged in!!!!</p>";
    echo "<p>Click <a href=\"login.php\">here</a> to get logged in.</p>";
	exit();
}
else if($_SESSION['SESS_ISADMIN'] == 0)
{
    echo "<p>You are trying to access the Admin Page<br>";
	echo "You are NOT an Admin!</p>";
	exit();
}
?>
	
<h1 align="center" >Administrator Area</h1>
<hr />
<form action=viewRequests.php method = "post">
	<input type = "submit" name = "viewRequests" style="width:200px; height:32px; font-size:22px;" value = "View Requests" />
</form>

</body>
</html>
