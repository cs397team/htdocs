<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<head>
<title>View Profile</title>
</head>

<body>
<div id="wrap">

<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all">
<div class="container" id="navbar">
	<ul id="anim">
	<li id="b0"><a class="navlink" href="member-index.php">Home</a></li>
	<li id="b1" class="a0"><a class="navlink" href="viewProfile.php">View Profile</a></li>
	<li id="b2"><a class="navlink" href="reservations.php">Approved Reservations</a></li>
	<li id="b3"><a class="navlink" href="pending.php">Pending Reservations</a></li>
	<li id="b4"><a class="navlink" href="searchByDate.php">Make a Reservation</a></li>
	<li id="b5" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>


<div id="content" align="center" style="padding-top:100px">
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
		$sql = "UPDATE user SET Name='{$name}', Email='{$email}' WHERE ID = '{$_SESSION['SESS_STUDENT_ID']}'";
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
			<table rules="all" cellpadding="4" class="green">
				<tr align='center'>
					<td><b>User ID</b></td>
					<td><?php echo $row['ID']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Name</b></td>
					<td><input type="text" name="name" value="<?php echo $row['Name']?>"></td>
				</tr>
				<tr align='center'>
					<td><b>Email</b></td>
					<td><input type="text" name="email" value="<?php echo $row['Email']?>"></td>
				</tr>
				<tr align='center'>
					<td colspan="2"><input type="submit" name="submit" value="Submit Edits"></td>
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
			<table rules="all" cellpadding="4" class="green">
				<tr align='center'>
					<td><b>User ID</b></td>
					<td><?php echo $row['ID']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Name</b></td>
					<td><?php echo $row['Name'] ?></td>
				</tr>
				<tr align='center'>
					<td><b>Email</b></td>
					<td><?php echo $row['Email']; ?></td>
				</tr>
				<tr align='center'>
					<td><b>Organizations</b></td>
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
