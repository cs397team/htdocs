<html>
<head>
<title>Edit Event</title>
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

		if( isset( $_POST["submit"] ) )
		{
			$title	 = $_POST["title"];
			$eventTimeStart = $_POST["eventStart"];
			$eventTimeEnd = $_POST["eventEnd"];
			$accessTimeStart = $_POST["accessStart"];
			$accessTimeEnd = $_POST["accessEnd"];
			$date = $_POST["date"];
			$numAttendees = $_POST["numAttend"];
			$decorations = isset( $_POST["decorations"] ) ? 1 : 0;
			$alcohol = isset( $_POST["alcohol"] ) ? 1 : 0;
			$prizes = isset( $_POST["prizes"] ) ? 1 : 0;
			$tickets = isset( $_POST["tickets"] ) ? 1 : 0;
			$outsideVendors = isset( $_POST["outsideVendors"] ) ? 1 : 0;
			$foodOption = $_POST["food"];
			$typeEvent = $_POST["typeEvent"];
			$sql = "UPDATE event, reservation
					SET title = '$title', eventTimeStart = '$eventTimeStart', 
					eventTimeEnd = '$eventTimeEnd', accessTimeStart = '$accessTimeStart',
					accessTimeEnd = '$accessTimeEnd', date = '$date', numAttendees = $numAttendees,
					decorations = $decorations, alcohol = $alcohol,
					prizes = $prizes, tickets = $tickets, outsideVendors = $outsideVendors,
					foodOption = $foodOption, typeOfEvent = '$typeEvent'
					WHERE reservation.id = {$_GET['reserveID']} AND reservation.eventID = event.id ";
			$result = mysql_query($sql);
			
			if(!$result)
			{
				echo $sql;
				echo mysql_error();
			}
			header('Location: '.$_SERVER['REQUEST_URI']);
		}
		if( isset($_POST['editEvent']) )
		{
	?>
			<form method="post">
			<table border='1'>
				<tr align='center'>
					<td>Event ID:</td>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr align='center'>
					<td>Title</td>
					<td><input type="text" name="title" value="<?php=($row['title'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Event start time</td>
					<td><input type="time" name="eventStart" value="<?php= $row['eventTimeStart']?>"></td>
				</tr>
				<tr align='center'>
					<td>Event end time</td>
					<td><input type="time" name="eventEnd" value="<?php= $row['eventTimeEnd']?>"></td>
				</tr>
				<tr align='center'>
					<td>Access start time</td>
					<td><input type="time" name="accessStart" value="<?php= $row['accessTimeStart']?>"></td>
				</tr>
				<tr align='center'>
					<td>Access end time</td>
					<td><input type="time" name="accessEnd" value="<?php= $row['accessTimeEnd']?>"></td>
				</tr>
				<tr align='center'>
					<td>Date</td>
					<td><input type="date" name="date" value="<?php=($row['date'])?>"></td
				</tr>
				<tr align='center'>
					<td>Number of Attendees</td>
					<td><input type="text" name="numAttend" value="<?php=($row['numAttendees'])?>"></td>
				</tr>
				<tr align='center'>
					<td>Decorations?</td>
					<td><input type="checkbox" name="decorations" <?php=( ($row['decorations']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Alcohol?</td>
					<td><input type="checkbox" name="alcohol" <?php=( ($row['alcohol']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Prizes?</td>
					<td><input type="checkbox" name="prizes" <?php=( ($row['prizes']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Tickets?</td>
					<td><input type="checkbox" name="tickets" <?php=( ($row['tickets']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td>Outside Vendors?</td>
					<td><input type="checkbox" name="outsideVendors" <?php=( ($row['outsideVendors']) ? ' checked="checked"' : '')?>></td>
				</tr>
				
				<tr align='center'>
					<td>Food Option</td>
					<td><select name="food">
						<option value="0" <?php=( $row['foodOption'] == '0' ? ' selected="selected" ' : '' )?>">Chartwell's Catering</option>
						<option value="1" <?php=( $row['foodOption'] == '1' ? ' selected="selected" ' : '' )?>">Bringing in Food</option>
						<option value="2" <?php=( $row['foodOption'] == '2' ? ' selected="selected" ' : '' )?>">No Food will be served</option>
					</select></td>
				</tr>
				
				<tr align='center'>
					<td>Type of Event</td>
					<td><input type="text" name="typeEvent" value="<?php=($row['typeOfEvent'])?>"></td>
				</tr>
				<tr align='center'>
					<td><input type="submit" name="submit" value="Submit Event"></td>
				</tr>
			</table>
			</form>
	<?php
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
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['eventTimeStart']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td>Event end time</td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['eventTimeEnd']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td>Access start time</td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['accessTimeStart']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td>Access end time</td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['accessTimeEnd']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td>Date</td>
					<td><?php echo date_format(date_create($row['date']), 'F jS Y'); ?></td>
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
					<td>Alcohol?</td>
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
					<td><?php 
						switch( $row['foodOption'] ) {
							case 0:
								echo "Chartwell's Catering";
								break;
							case 1:
								echo "Bringing in Food";
								break;
							case 2:
								echo "No food will be served";
								break;
						} 
						
						?></td>
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
