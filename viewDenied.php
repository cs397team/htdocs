<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Denied Requests</title>
</head>

<body>
<div id="wrap">
<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" style="padding-right:30px;" />
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<hr />
<h2 align="center" >Denied Requests</h2>

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
	echo "<p align=\"center\"> Hey, you're not logged in!!!! </p>";
    echo "<p align=\"center\"> Click <a href=\"login.php\">here</a> to get logged in. </p>";
	exit();
}

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT room.roomNumber, event.title, reservation.primaryRoomNumber, event.eventTimeStart, reservation.id, user.name
		FROM reservation, event, building, room, user
		WHERE reservation.eventId = event.id AND approval = 'Denied' AND 
		reservation.primaryRoomNumber = room.ID AND room.buildingName = building.name AND
		user.id = reservation.user";
		
	$result = mysql_query($sql);
	if(mysql_num_rows($result) != 0)
	{
?>
		<table border='1' id='table'>
		<tr align='center'>
			<td>Event title</td>
			<td>Event Location </td>
			<td>Event Start</td>
			<td>Organizer's Name</td>
		</tr>
		
<?php
		while( $row = mysql_fetch_array($result) )
		{
?>
			<tr align='center'>
				<form action="eventDetails.php" method="post">
					<td><a href="eventDetails.php?reserveID=<? print $row['id']?>" >
					<?php echo $row['title']; ?>
					</a></td>
				</form>
				
				<td><?php echo $row['roomNumber']; ?></td>
				<td><?php echo date_format(date_create($row['eventTimeStart']), 'F jS Y g:ia'); ?></td>
				<td><?php echo $row['name']; ?></td>				
			</tr>
<?php
		}
?>
		</table>
<?php
	}
	else { echo "<p align=\"center\"> There are no reservations at this time. </p>"; }
?>

</body>
</html>
