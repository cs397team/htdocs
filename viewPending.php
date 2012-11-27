<html>
<head>
<title>Pending Requests</title>
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

	
<h1 align="center" >Pending Requests</h1>
<hr />

<?php

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT event.title, reservation.primaryRoomNumber, event.eventTimeStart, reservation.id, user.name
		FROM reservation, event, building, room, user
		WHERE reservation.eventId = event.id AND approval = 'Pending' AND 
		reservation.primaryRoomNumber = room.roomNumber AND room.buildingName = building.name AND
		user.id = reservation.user";

	$result = mysql_query($sql);
	
	if( $result )
	{
?>
		<table border='1' id='table'>
		<tr align='center'>
			<td>Event title</td>
			<td>Event Location </td>
			<td>Event Start</td>
			<td>Organizer's Name</td>
			<td bgcolor="#000000" width="2"></td>
			<td>Reason For Decision</td>
		</tr>
		
<?php
		while( $row = mysql_fetch_array($result) )
		{
?>
			<tr align='center'>
				<form action="eventDetails.php" method="post">
					<td rowspan="2"><a href="eventDetails.php?reserveID=<? print $row['id']?>" >
					<?php echo $row['title']; ?>
					</a></td>
				</form>
				
				<td rowspan="2"><?php echo $row['primaryRoomNumber']; ?></td>
				<td rowspan="2"><?php echo date_format(date_create($row['eventTimeStart']), 'F jS Y g:ia'); ?></td>
				<td rowspan="2"><?php echo $row['name']; ?></td>
				<td rowspan="2" bgcolor="#000000" width="2"></td>
				<form action="emailResponse.php" method="post">
					<td align='left' rowspan="2"><textarea name="reason" rows="3" col="50"></textarea></td>
					<td><input type="submit" name="approve" value="Approve" style="width:100%"></td>
					<input type="hidden" name="reservationID" value="<?=intval($row['id'])?>" >
				</form>
				
			</tr>
			<tr align ='center'>
				<form action="emailResponse.php" method="post">
					<td><input type="submit" name="deny" value="Deny" style="width:100%"></td>
					<input type="hidden" name="reservationID" value="<?=intval($row['id'])?>" >
				</form>
			</tr>
<?php
		}
?>
		</table>
<?php
	}
?>

</body>
</html>
