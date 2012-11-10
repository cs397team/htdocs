<html>
<head>
<title>Member Area</title>
</head>
<body>
<h1>Member Area</h1>
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
    else if($_SESSION['SESS_ISADMIN'] == 1)
    {
        //If the admin trys to access the normal member-index, just forward him to his own index
        header("location: admin-index.php");
    }
    
    echo "<p>Welcome back to the system, ".$_SESSION['SESS_NAME']."!</p>";
?>
<p>
<table border='1'>
<tr><td>
<h3>Menu</h3>
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


</body>
</html>
