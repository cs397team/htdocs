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
    echo "<p>You are trying to access an Administrator page<br>";
	echo "You are NOT an Admin!</p>";
	exit();
}
?>

<h1 align="center" >Search Results</h1>
<hr />

<?php

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	//Reservation id is used by eventDetails.php
	$sql = "SELECT event.title, reservation.id
			FROM event, reservation
			WHERE event.title LIKE '%{$_POST['searchName']}%' AND reservation.eventId=event.id
			GROUP BY event.title";
	$result = mysql_query($sql);
	
	if($result)
	{
?>
		<table border='1' id='table'>
		<tr align='center'>
			<td>Event title</td>
		</tr>			
<?php
		while( $row = mysql_fetch_array($result) )
		{
?>			<tr align='center'>
				<form action="eventDetails.php" method="post">
					<td><a href="eventDetails.php?reserveID=<?php print $row['id']?>" >
					<?php echo $row['title']; ?>
					</a></td>
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