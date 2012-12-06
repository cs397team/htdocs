<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Search</title>
</head>

<body>
<div id="wrap">
<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<div class="container" id="navbar">
	<ul id="anim">
	<li id="b0" class="a0"><a class="navlink" href="admin-index.php">Home</a></li>
	<li id="b1"><a class="navlink" href="viewPending.php">Pending Reservations</a></li>
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
/*else if($_SESSION['SESS_ISADMIN'] == 0)
{
    echo "<p>You are trying to access an Administrator page<br>";
	echo "You are NOT an Admin!</p>";
	exit();
}*/

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	echo "<h2 align=\"center\">Search Results for {$_POST['searchName']}</h2>";
	
	mysql_select_db("r3", $con);
	//Reservation id is used by eventDetails.php
	$sql = "SELECT event.title, reservation.id
			FROM event, reservation
			WHERE event.title LIKE '%{$_POST['searchName']}%' AND reservation.eventId=event.id
			GROUP BY event.title";
	$result = mysql_query($sql);
		
	if($result)
	{		
		while( $row = mysql_fetch_array($result) )
		{
?>			
			<ul align='center' style="list-style-type: none;">
				<form action="eventDetails.php" method="post">
					<li><a href="eventDetails.php?reserveID=<?php print $row['id']?>" >
					<?php echo $row['title']; ?>
					</a></li>
				</form>
			</ul>
<?php
		}
	}
?>

</div>
</div>
</body>
</html>