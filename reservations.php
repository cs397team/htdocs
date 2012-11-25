<html>
<title>Approved Reservations</title>

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

$result = mysql_query("SELECT r1.id, r2.buildingName, r2.roomNumber, e1.title, e1.date, e1.eventTimeStart, e1.eventTimeEnd 
						FROM reservation AS r1, event AS e1, room AS r2 
						WHERE r1.Approval = 'Approved' AND r1.user = {$_SESSION['SESS_STUDENT_ID']} 
						AND r1.eventid = e1.id AND ((r1.primaryRoomNumber = r2.roomNumber AND r1.primaryRoomNumber IS NOT NULL) OR 
													(r1.backupRoomNumber = r2.roomNumber AND r1.backupRoomNumber IS NOT NULL))");						
			
echo	"<table border=\"1\">
		<tr>
		<td>Reservation ID</td>
		<td>Event Title</td>
		<td>Date</td>
		<td>Time Start</td>
		<td>Time End</td>
		<td>Building</td>
		<td>Room</td>
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

<p>

</p>


</html>