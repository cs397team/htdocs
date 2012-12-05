<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>R3 Homepage</title>
</head>

<body>
<div id="wrap">
<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<hr />
<h2 align="center">Welcome to R<sup>3</sup> Room Reservation System!</h2>

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
