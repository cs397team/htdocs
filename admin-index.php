<html>
<html>
<head>
<title>Admin Area</title>
</head>
<body>
<h1>Admin Area</h1>
<hr />
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
<p>
<table border='1'>
<tr><td>
<h3>Menu</h3>
</td></tr>

<tr><td>
<a href="viewRequests.php">View Requests</a>
</td></tr>
</table>
</p>

<p>Click <a href="logout.php">here</a> to logout.</p>

</body>
</html>
