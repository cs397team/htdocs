<html>
<head>
<title>Admin Area</title>
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
else if($_SESSION['SESS_ISADMIN'] == 0)
{
    echo "<p>You are trying to access an Admin only page<br>";
	echo "You are NOT an Admin!</p>";
	exit();
}

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT *
			FROM event
			WHERE event.id IN ( SELECT event.id
								FROM event, reservation
								WHERE event.id = reservation.eventID AND reservation.id = {$_GET['reserveID']} ) ";
	$result = mysql_query( $sql );
	if($result)
	{
	$row = mysql_fetch_array($result);

		if( isset($_POST['editEvent']) )
		{
	?>
			<form action="" method="post">
			<table border='1'>
				<tr align='center'>
					<td>Event ID:</td>
					<td><input type="text" name="eventID" value="<?=($row['id'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Title</td>
					<td><input type="text" name="eventID" value="<?=($row['title'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Event start time</td>
					<td><input type="time" name="eventID" value="<?=($row['eventTimeStart'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Event end time</td>
					<td><input type="time" name="eventID" value="<?=($row['eventTimeEnd'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Access start time</td>
					<td><?php echo $row['accessTimeStart']; ?></td>
				</tr>
				<tr align='center'>
					<td>Access end time</td>
					<td><?php echo $row['accessTimeEnd']; ?></td>
				</tr>
				<tr align='center'>
					<td>Date</td>
					<td><input type="date" name="eventID" value="<?=($row['date'])?>"></td
				</tr>
				<tr align='center'>
					<td>Number of Attendees</td>
					<td><input type="text" name="eventID" value="<?=($row['numAttendees'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Decorations?</td>
					<td><input type="checkbox" name="eventID" <?=( ($row['decorations']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Alcohol?</td>
					<td><input type="checkbox" name="eventID" <?=( ($row['alcohol']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Prizes?</td>
					<td><input type="checkbox" name="eventID" <?=( ($row['prizes']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Tickets?</td>
					<td><input type="checkbox" name="eventID" <?=( ($row['tickets']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Outside Vendors?</td>
					<td><input type="checkbox" name="eventID" <?=( ($row['outsideVendors']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Food Option</td>
					<td><?php echo $row['foodOption']; ?></td>
				</tr>
				<tr align='center'>
					<td>Type of Event</td>
					<td><input type="text" name="eventID" value="<?=($row['typeOfEvent'])?>"></td>
				</tr>
				<tr align='center'>
					<form action="" method="post">
						<td><input type="submit" name="editEvent" value="Edit Event"></td>
					</form>
				</tr>
			</table>
			</form>
	<?
		}
		else
		{
	?>
			<table border='1'>
				<tr align='center'>
					<td>Event ID:</td>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr align='center'>
					<td>Title</td>
					<td><?php echo $row['title']; ?></td>
				</tr>
				<tr align='center'>
					<td>Event start time</td>
					<td><?php echo $row['eventTimeStart']; ?></td>
				</tr>
				<tr align='center'>
					<td>Event end time</td>
					<td><?php echo $row['eventTimeEnd']; ?></td>
				</tr>
				<tr align='center'>
					<td>Access start time</td>
					<td><?php echo $row['accessTimeStart']; ?></td>
				</tr>
				<tr align='center'>
					<td>Access end time</td>
					<td><?php echo $row['accessTimeEnd']; ?></td>
				</tr>
				<tr align='center'>
					<td>Date</td>
					<td><?php echo $row['date']; ?></td>
				</tr>
				<tr align='center'>
					<td>Number of Attendees</td>
					<td><?php echo $row['numAttendees']; ?></td>
				</tr>
				<tr align='center'>
					<td>Decorations?</td>
					<td><?php echo $row['decorations'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td>Alchohol?</td>
					<td><?php echo $row['alcohol'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td>Prizes?</td>
					<td><?php echo $row['prizes'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td>Tickets?</td>
					<td><?php echo $row['tickets'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td>Outside Vendors?</td>
					<td><?php echo $row['outsideVendors'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td>Food Option</td>
					<td><?php echo $row['foodOption']; ?></td>
				</tr>
				<tr align='center'>
					<td>Type of Event</td>
					<td><?php echo $row['typeOfEvent']; ?></td>
				</tr>
				<tr align='center'>
					<form action="" method="post">
						<td><input type="submit" name="editEvent" value="Edit Event"></td>
					</form>
				</tr>
			</table>
<?		
		}
	}
	else
	{
		echo "Event not found";
	}
?>
</body>
</html>
