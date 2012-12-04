<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>Pending Requests</title>
</head>

<body>
<div id="wrap">

<img src="images/Logo_Reverse__356.jpg" height="116" width="131" alt="S&T logo" align="left" style="padding-right:30px;"/>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<div class="container" id="navbar">
	<ul id="sprite">
	<li id="b0" class="a0"><a class="navlink" href="member-index.php">Home</a></li>
	<li id="b1"><a class="navlink" href="reservations.php">Approved Reservations</a></li>
	<li id="b2"><a class="navlink" href="pending.php">Pending Reservations</a></li>
	<li id="b3"><a class="navlink" href="searchByDate.php">Reserve</a></li>
	<li id="b4" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>


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
	echo "<p align=\"center\"> Hey, you're not logged in!!!! </p>";
    echo "<p align=\"center\"> Click <a href=\"login.php\">here</a> to get logged in. </p>";
	exit();
}

	// Connect to the sql database
	$con = mysql_connect("localhost","root");
	if(!$con){
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
	
	$sql = "SELECT *
			FROM USER
			WHERE user.ID ={$_SESSION['SESS_STUDENT_ID']}";

	$result = mysql_query($sql);
	
	if( isset( $_POST["submit"] ) )
	{
		$name = $_POST['name'];
		$email = $_POST['email'];
		$sql = "UPDATE user
				SET Name='{$name}', Email='{$email}'";
		$result = mysql_query($sql);
		if( !$result )
		{
			echo $sql;
			echo $result;
		}
		header('Location: '.$_SERVER['REQUEST_URI']);
	}
	
	if( isset($_POST['editProfile']) )
	{
		while( $row = mysql_fetch_array($result) )
		{
?>
			<form method="post">
			<table border ="1">
				<tr align='center'>
					<td>User ID:</td>
					<td><?php echo $row['ID']; ?></td>
				</tr>
				<tr align='center'>
					<td>Name</td>
					<td><input type="text" name="name" value="<?php echo $row['Name']?>"></td>
				</tr>
				<tr align='center'>
					<td>Email</td>
					<td><input type="text" name="email" value="<?php echo $row['Email']?>"></td>
				</tr>
				<tr align='center'>
					<td colspan="2"><input type="submit" name="submit" value="Submit"></td>
				</tr>
			</table>
			</form>
<?php
		}
	}
	else if(mysql_num_rows($result) != 0)
	{
		while( $row = mysql_fetch_array($result) )
		{
?>
			<table border='1' id='table'>
				<tr align='center'>
					<td>User ID</td>
					<td><?php echo $row['ID']; ?></td>
				</tr>
				<tr align='center'>
					<td>Name</td>
					<td><?php echo $row['Name'] ?></td>
				</tr>
				<tr align='center'>
					<td>Email</td>
					<td><?php echo $row['Email']; ?></td>
				</tr>
				<tr align='center'>
					<td>Organizations</td>
					<td>
					<?php
						$sql = "SELECT *
								 FROM member_of
								 WHERE member_of.UserID = {$_SESSION['SESS_STUDENT_ID']}";
						$orgs = mysql_query( $sql );
						while( $org = mysql_fetch_array( $orgs ) )
						{
							echo $org['org_name'];
							?><br /><?php
						}
					?>
					</td>
				</tr>
				<tr align ='center'>
					<form action="" method="post">
						<td colspan="2"><input type="submit" name="editProfile" value="Edit Profile"></td>
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

</body>
</html>
