<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Pending Requests</title>
</head>

<body>
<div id="wrap">

<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<div class="container" id="navbar">
	<ul id="anim">
	<li id="b0"><a class="navlink" href="admin-index.php">Home</a></li>
	<li id="b1" class="a0"><a class="navlink" href="viewPending.php">Pending Reservations</a></li>
	<li id="b2"><a class="navlink" href="viewAccepted.php">Accepted Reservations</a></li>
	<li id="b3"><a class="navlink" href="viewDenied.php">Denied Reservations</a></li>
	<li id="b4" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>

<div id="content" align="center" style="padding-top:100px;">

<?php 
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

//Start session
session_start();
	
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) {
	header("location: login.php");
}
else if($_SESSION['SESS_ISADMIN'] == 0)
{
    echo "<h2>You are trying to access the Admin Page<br>";
    echo "You are NOT an Admin!</h2>";
    exit();
}

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	echo "<h2 align=\"center\" style=\"color:rgb(0,133,63)\">Reservations for Approval/Denial:</h2>";	
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT room.roomNumber, event.title, reservation.primaryRoomNumber, event.eventTimeStart, reservation.id, user.name
		FROM reservation, event, building, room, user
		WHERE reservation.eventId = event.id AND approval = 'Pending' AND 
		reservation.primaryRoomNumber = room.ID AND room.buildingName = building.name AND
		user.id = reservation.user";

	$result = mysql_query($sql);
	
	if(mysql_num_rows($result) != 0)
	{
?>
		<table rules="all" cellpadding="4" class="green">
		<tr align='center'>
			<td><b>Event Title</b></td>
			<td><b>Event Location</b></td>
			<td><b>Event Start</b></td>
			<td><b>Organizer's Name</b></td>
			<td><b>Reason For Decision</b></td>
			<td><b>Decision</b></td>
		</tr>
		
<?php
		while( $row = mysql_fetch_array($result) )
		{
?>
			<tr align='center'>
				<form action="eventDetails.php" method="post">
					<td rowspan="2"><a href="eventDetails.php?reserveID=<?php echo $row['id']?>" >
					<?php echo $row['title']; ?>
					</a></td>
				</form>
				
				<td rowspan="2"><?php echo $row['roomNumber']; ?></td>
				<td rowspan="2"><?php echo date_format(date_create($row['eventTimeStart']), 'F jS Y g:ia'); ?></td>
				<td rowspan="2"><?php echo $row['name']; ?></td>
				<form action="emailResponse.php" method="post">
					<td align='left' rowspan="2"><textarea name="reason" rows="3" col="50"></textarea></td>
					<td><input type="submit" name="approve" value="Approve" style="width:100%"></td>
					<input type="hidden" name="reservationID" value="<?php echo intval($row['id'])?>" >
				</form>				
			</tr>
			<tr align ='center'>
				<form action="emailResponse.php" method="post">
					<td><input type="submit" name="deny" value="Deny" style="width:100%"></td>
					<input type="hidden" name="reservationID" value="<?php echo intval($row['id'])?>" >
				</form>
			</tr>
<?php
		}
?>
		</table>
<?php
	}
	else { echo "<p align=\"center\"> There are no pending reservation requests at this time. </p>"; }
?>

</div>
</body>
</html>
