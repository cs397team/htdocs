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
<body>
<h1>Logout of the R3 System</h1>
<hr />
<p>&nbsp;</p>
<h4 class="err">You have been logged out.</h4>
<p>Click here to <a href="login.php">Login</a></p>
</body>
</html>