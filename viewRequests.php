<html>
<head>
<title>Current Requests</title>
</head>

<body bgcolor = "black" link = "white" vlink = "white" text="white">

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

	
<h1 align="center" >Current Requests</h1>
<hr />

<?php

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT ID, user, primaryRoomNumber
		FROM reservation
		WHERE approval = 'Pending'";

	$result = mysql_query($sql);
	if( $result )
	{
		echo "<table border='1'>";
		echo "<tr>";
			echo "<td>Reservation ID</td>";
			echo "<td>User ID</td>";
			echo "<td>Room #</td>";
		echo "</tr>";
		
		while( $row = mysql_fetch_array($result) )
		{
			echo "<tr>";
				echo "<td>".$row['ID']."</td>";
				echo "<td>".$row['user']."</td>";
				echo "<td>".$row['primaryRoomNumber']."</td>";
				
			echo "</tr>";
		}
		echo "</table>";
	}
?>
<br><br><br><br>
<form method="post">
	<table border ='1'>
	
	<tr>
	<td>Reservation # </td> <td><input type="ID" name="reservationID" /> </td>
	</tr>
	
	</table>
	
	<input type="submit" name = "approve" value = "Approve Request" /> 
	<input type="submit" name = "deny" value = "Deny Request" /> 
</form>
<?php
	if( isset($_POST["approve"] ) )
	{
		$id = $_POST["reservationID"];
		$approve = "UPDATE reservation
					SET approval = 'Approved'
					WHERE ID = {$id}";
		$result = mysql_query( $approve );
	}
	if( isset($_POST["deny"] ) )
	{
		$id = $_POST["reservationID"];
		$deny = "UPDATE reservation
					SET approval = 'Denied'
					WHERE ID = {$id}";
		$result = mysql_query( $deny );
	}
?>
</body>
</html>
