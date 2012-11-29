<style>
#wrap {width: 900px; margin: 0 auto;}
</style>

<html>
<head>
<title>Approved Reservations</title>
</head>

<body>
<div id="wrap">
<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" />
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<hr />

<div id="content">
<!--<h2 style="color:rgb(0,133,63)">Approved Reservations</h2>-->

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
	
echo "<h2 style=\"color:rgb(0,133,63)\">Approved Reservations for {$_SESSION['SESS_NAME']} </h2>";
	
mysql_select_db("r3", $con);

$result = mysql_query("SELECT r1.id, r2.buildingName, r2.roomNumber, e1.title, e1.date, e1.eventTimeStart, e1.eventTimeEnd 
						FROM reservation AS r1, event AS e1, room AS r2 
						WHERE r1.Approval = 'Approved' AND r1.user = {$_SESSION['SESS_STUDENT_ID']} 
						AND r1.eventid = e1.id AND ((r1.primaryRoomNumber = r2.ID AND r1.primaryRoomNumber IS NOT NULL) OR 
													(r1.backupRoomNumber = r2.ID AND r1.backupRoomNumber IS NOT NULL))");						
			
echo	"<table rules=\"all\" style=\"border:1 solid rgb(0,133,63);\" cellpadding=\"4\">
		<tr>
		<td><b>Reservation ID</b></td>
		<td><b>Event Title</b></td>
		<td><b>Date</b></td>
		<td><b>Time Start</b></td>
		<td><b>Time End</b></td>
		<td><b>Building</b></td>
		<td><b>Room</b></td>
		</tr>";
			
while($row = mysql_fetch_array($result))
{
	echo	"<tr>
			<td>{$row['id']}</td>
			<td>{$row['title']}</td>
			<td>{$row['date']}</td>
			<td>{$row['eventTimeStart']}</td>
			<td>{$row['eventTimeEnd']}</td>
			<td>{$row['buildingName']}</td>
			<td>{$row['roomNumber']}</td>
			</tr>";
}

echo "</table>";

?>

</div>
</div>
</body>
</html>