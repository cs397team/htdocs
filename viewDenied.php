<html>
<head>
<title>Denied Requests</title>
</head>

<div align="center">
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
?>

	
<h1 align="center" >Denied Requests</h1>
<hr />

<?php

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT event.title, reservation.primaryRoomNumber, event.eventTimeStart, user.name
		FROM reservation, event, building, room, user
		WHERE reservation.eventId = event.id AND approval = 'Denied' AND 
		reservation.primaryRoomNumber = room.roomNumber AND room.buildingName = building.name AND
		user.id = reservation.user";

	$result = mysql_query($sql);
	if( $result )
	{
		echo "<table border='1'>";
		echo "<tr>";
			echo "<td>Event title</td>";
			echo "<td>Event Location </td>";
			echo "<td>Event Start</td>";
			echo "<td>Organizer's Name</td>";
		echo "</tr>";
		
		while( $row = mysql_fetch_array($result) )
		{
			echo "<tr>";
				echo "<td>".$row['title']."</td>";
				echo "<td>".$row['primaryRoomNumber']."</td>";
				echo "<td>".$row['eventTimeStart']."</td>";
				echo "<td>".$row['name']."</td>";
				
			echo "</tr>";
		}
		echo "</table>";
	}
?>
</body>
</html>
