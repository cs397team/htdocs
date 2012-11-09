<html>
<title>R3 Homepage</title>

<head>
<h1>Welcome to R3 Room Reservation System!</h1>
</head>

<body>
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
	echo "<p>You are currently not logged in.</p>";
    echo "<p>Click <a href=\"login.php\">here</a> to get logged in and access the rest of the system.</p>";
} else {
    echo "<p>You are currently logged in</p>";
    echo "<p>Click <a href=\"member-index.php\">here</a> to go to the member area.</p>";
    echo "<p>Click <a href=\"logout.php\">here</a> to logout.</p>";
}
?>
</body>
</html>
