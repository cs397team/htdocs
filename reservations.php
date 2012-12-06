<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Approved Reservations</title>
</head>

<body>
<div id="wrap">
<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>

<div class="container" id="navbar">
	<ul id="anim">
	<li id="b0"><a class="navlink" href="member-index.php">Home</a></li>
	<li id="b1"><a class="navlink" href="viewProfile.php">View Profile</a></li>
	<li id="b2" class="a0"><a class="navlink" href="reservations.php">Approved Reservations</a></li>
	<li id="b3"><a class="navlink" href="pending.php">Pending Reservations</a></li>
	<li id="b4"><a class="navlink" href="searchByDate.php">Make a Reservation</a></li>
	<li id="b5" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>

<div id="content" style="padding-top:100px;">

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

// Connect to the sql database
$con = mysql_connect("localhost","root");
	
if(!$con)
{
	die('Could not connect: ' . mysql_error());
}
	
echo "<h2 align=\"center\" style=\"color:rgb(0,133,63)\">Approved Reservations for {$_SESSION['SESS_NAME']} </h2>";
	
mysql_select_db("r3", $con);

$result = mysql_query("SELECT r1.id, r2.buildingName, r2.roomNumber, e1.title, e1.date, e1.eventTimeStart, e1.eventTimeEnd 
						FROM reservation AS r1, event AS e1, room AS r2 
						WHERE r1.Approval = 'Approved' AND r1.user = {$_SESSION['SESS_STUDENT_ID']} 
						AND r1.eventid = e1.id AND r1.primaryRoomNumber = r2.ID");						

if (mysql_num_rows($result) != 0)
{													
	echo	"<table align=\"center\" rules=\"all\" cellpadding=\"4\" class=\"green\">
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
				<td>";
?>
				<form action="eventDetails.php" method="post">
					<a href="eventDetails.php?reserveID=<?php echo $row['id']?>">
					<?php echo $row['title']; ?>
					</a></td>
				</form>
<?php
		echo "	<td>{$row['date']}</td>
				<td>{$row['eventTimeStart']}</td>
				<td>{$row['eventTimeEnd']}</td>
				<td>{$row['buildingName']}</td>
				<td>{$row['roomNumber']}</td>
				</tr>";
	}

	echo "</table>";
}
else { echo "<p align=\"center\"> You do not have any reservations at this time. </p>"; }

?>

</div>
</div>
</body>
</html>