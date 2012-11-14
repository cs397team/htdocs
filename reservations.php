<html>
<title>Current Reservations</title>

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

// Connect to the sql database
$con = mysql_connect("localhost","root");
	
if(!$con)
{
	die('Could not connect: ' . mysql_error());
}
	
mysql_select_db("r3", $con);

$result = mysql_query("SELECT * FROM reservation WHERE r1.Approval IS TRUE AND r1.user = u1.id");

?>

<p>
<table border="1">
<tr>
<td>Reservation ID</td>
<td>Event Title</td>
<td>Date</td>
<td>Time Start</td>
<td>Time End</td>
<td>Building</td>
<td>Room</td>
</tr>
<tr>
</tr>
</table>
</p>


</html>