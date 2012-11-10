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
    
    echo "<p>Welcome back to the system, ".$_SESSION['SESS_NAME']."!</p>";
    echo "<p>Click <a href=\"logout.php\">here</a> to logout.</p>"
?>

</body>
</html>
