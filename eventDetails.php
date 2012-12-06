<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Event Details</title>
</head>

<body>
<div id="wrap">

<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">

<div id="content" align="center">

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
	echo "<div class=\"container\" id=\"navbar\">
			<ul id=\"anim\">
			<li id=\"b0\"><a class=\"navlink\" href=\"member-index.php\">Home</a></li>
			<li id=\"b1\"><a class=\"navlink\" href=\"reservations.php\">Approved Reservations</a></li>
			<li id=\"b2\"><a class=\"navlink\" href=\"pending.php\">Pending Reservations</a></li>
			<li id=\"b3\"><a class=\"navlink\" href=\"searchByDate.php\">Reserve</a></li>
			<li id=\"b4\" style=\"border-right:1px solid #1f1f1f;\"><a class=\"navlink\" href=\"logout.php\">Log Out</a></li>
			</ul>
		 </div>";
}
else
{
	echo "<div class=\"container\" id=\"navbar\">
			<ul id=\"anim\">
			<li id=\"b0\"><a class=\"navlink\" href=\"admin-index.php\">Home</a></li>
			<li id=\"b2\"><a class=\"navlink\" href=\"viewPending.php\">Pending Reservations</a></li>
			<li id=\"b1\"><a class=\"navlink\" href=\"viewAccepted.php\">Accepted Reservations</a></li>
			<li id=\"b3\"><a class=\"navlink\" href=\"viewDenied.php\">Denied Reservations</a></li>
			<li id=\"b4\" style=\"border-right:1px solid #1f1f1f;\"><a class=\"navlink\" href=\"logout.php\">Log Out</a></li>
			</ul>
		 </div>";
}

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	echo "<div id=\"content\" align=\"center\" style=\"padding-top:80px;\">
		  <h2 align=\"center\">Event Details</h2>";
	
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
			<table rules="all" cellpadding="4" class="green">
				<tr align='center'>
					<td><b>Event ID</b></td>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Title</b></td>
					<td><input type="text" name="title" value="<?php echo $row['title']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Event start time</b></td>
					<td><input type="time" name="eventStart" value="<?php echo $row['eventTimeStart']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Event end time</b></td>
					<td><input type="time" name="eventEnd" value="<?php echo $row['eventTimeEnd']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Access start time</b></td>
					<td><input type="time" name="accessStart" value="<?php echo $row['accessTimeStart']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Access end time</b></td>
					<td><input type="time" name="accessEnd" value="<?php echo $row['accessTimeEnd']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Date</b></td>
					<td><input type="date" name="date" value="<?php echo $row['date']?>"></td
				</tr>
				<tr align='center'>
					<td><b>Number of Attendees</b></td>
					<td><input type="text" name="numAttend" value="<?php echo $row['numAttendees']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Decorations?</b></td>
					<td><input type="checkbox" name="decorations" <?php echo ( ($row['decorations']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td><b>Alcohol?</b></td>
					<td><input type="checkbox" name="alcohol" <?php echo ( ($row['alcohol']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td><b>Prizes?</b></td>
					<td><input type="checkbox" name="prizes" <?php echo ( ($row['prizes']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td><b>Tickets?</b></td>
					<td><input type="checkbox" name="tickets" <?php echo ( ($row['tickets']) ? ' checked="checked"' : '')?>></td>
				</tr>
				<tr align='center'>
					<td><b>Outside Vendors?</b></td>
					<td><input type="checkbox" name="outsideVendors" <?php echo ( ($row['outsideVendors']) ? ' checked="checked"' : '')?>></td>
				</tr>
				
				<tr align='center'>
					<td><b>Food Option</b></td>
					<td><select name="food">
						<option value="0" <?php echo ( $row['foodOption'] == '0' ? ' selected="selected" ' : '' )?> >Chartwell's Catering</option>
						<option value="1" <?php echo ( $row['foodOption'] == '1' ? ' selected="selected" ' : '' )?> >Bringing in Food</option>
						<option value="2" <?php echo ( $row['foodOption'] == '2' ? ' selected="selected" ' : '' )?> >No Food will be served</option>
					</select></td>
				</tr>
				
				<tr align='center'>
					<td><b>Type of Event</b></td>
					<td><input type="text" name="typeEvent" value="<?php echo ($row['typeOfEvent'])?>"></td>
				</tr>
				<tr align='center'>
					<td colspan="2"><input type="submit" name="submit" value="Submit Event Edits"></td>
				</tr>
			</table>
			</form>
	<?php
		}
		else
		{
	?>
			<table rules="all" cellpadding="4" class="green">
				<tr align='center'>
					<td><b>Event ID</b></td>
					<td><?php echo $row['id']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Title</b></td>
					<td><?php echo $row['title']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Event start time</b></td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['eventTimeStart']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Event end time</b></td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['eventTimeEnd']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Access start time</b></td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['accessTimeStart']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Access end time</b></td>
					<?php
					$sql = "SELECT TIME_FORMAT( '{$row['accessTimeEnd']}','%l:%i:%S %p' )";
					$timeFrmt = mysql_query( $sql );
					$rowFrmt = mysql_fetch_array($timeFrmt);
					?>
					<td><?php echo $rowFrmt[0]; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Date</b></td>
					<td><?php echo date_format(date_create($row['date']), 'F jS Y'); ?></td>
				</tr>
				<tr align='center'>
					<td><b>Number of Attendees</b></td>
					<td><?php echo $row['numAttendees']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Decorations?</b></td>
					<td><?php echo $row['decorations'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Alcohol?</b></td>
					<td><?php echo $row['alcohol'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Prizes?</b></td>
					<td><?php echo $row['prizes'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Tickets?</b></td>
					<td><?php echo $row['tickets'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Outside Vendors?</b></td>
					<td><?php echo $row['outsideVendors'] ? 'Yes' : 'No'; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Food Option</b></td>
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
					<td><b>Type of Event</b></td>
					<td><?php echo $row['typeOfEvent']; ?></td>
				</tr>
				<?php if(($_SESSION['SESS_ISADMIN'] == 1) )
				{
				?>
					<tr align='center'>
					<form action="" method="post">
						<td colspan='2'><input type="submit" name="editEvent" value="Edit Event"></td>
					</form>
					</tr>
				<?php
				}
				?>
			</table>

<?php		
		}
	}
	else
	{
		echo "Event not found";
	}
?>
</br>


</div>
</div>
</body>
</html>
