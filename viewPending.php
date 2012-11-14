<html>
<head>
<title>Current Requests</title>
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
	
	if( isset( $_POST["approve"] ) )
	{
		$id = $_POST["reservationID"];
		$approve = mysql_query( "UPDATE reservation
					SET approval = 'Approved'
					WHERE ID = {$id}" );
		
		//$to = mysql_query( "SELECT Email
			//				FROM user, reservation
				//			WHERE user.ID = reservation.user AND reservation.ID = {$id}");
		$to = "<nsp2t5@mst.edu>";
		$reservationInfo = mysql_query("SELECT event.title, reservation.primaryRoomNumber, event.eventTimeStart
										FROM reservation, event, building, room
										WHERE reservation.eventId = event.id AND approval = 'Pending' AND reservation.primaryRoomNumber = room.roomNumber AND room.buildingName = building.name" );
		
		$subject = "Your reservation request has been accepted!";
		//$body = "(string){$reservationInfo["title"]},{$reservationInfo["primaryRoomNumber"]},{$reservationInfo["eventTimeStart"]}";
		$body = "";
		$headers = "From: nsp2t5@mst.edu";
		mail((string)$to,$subject,$body);
	}
	
	if( isset($_POST["deny"] ) )
	{
		$id = $_POST["reservationID"];
		$deny = mysql_query( "UPDATE reservation
					SET approval = 'Denied'
					WHERE ID = {$id}" );
		
	}
	
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
				
				<td><?php echo $row['primaryRoomNumber']; ?></td>
				<td><?php echo $row['eventTimeStart']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<form action="" method="post">
					<td><input type="submit" name="approve" value="Approve"></td>
					<input type="hidden" name="reservationID" value="<?=intval($row['id'])?>" >
				</form>
				
				<form action="" method="post">
					<td><input type="submit" name="deny" value="Deny"></td>
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
