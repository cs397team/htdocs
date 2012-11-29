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
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) 
{
    header("location: login.php");
} 
else
{
    if($_SESSION['SESS_ISADMIN'] == 0)
    {
        header("location: member-index.php");
    }
    else
    {
        header("location: admin-index.php");
    }
}
?>
</body>
</html>
