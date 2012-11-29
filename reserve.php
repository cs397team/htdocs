<!-- HTML room reservation form -->
<html>
<title>Reservation Time!</title>
<?php

function populateOptionList($labelString, $keyName, $tableName, $labelFieldName, $valueFieldName) {
    if($labelFieldName != $valueFieldName) {
	    $result = mysql_query("SELECT ".$labelFieldName.", ".$valueFieldName." FROM ".$tableName);
	} else {
	    $result = mysql_query("SELECT ".$labelFieldName." FROM ".$tableName);
	}
		
	echo "<tr><td>".$labelString.":</td>
	          <td><select name=\"".$keyName."\">
			      <option value=\"default\">Select a value</option>";
	
	while($row = mysql_fetch_array($result))
	{
	    echo "<option value=\"".$row[$valueFieldName]."\"";
		if($labelString == "Primary Contact" && $row[$valueFieldName] == $_SESSION['SESS_STUDENT_ID']) {
		    echo " selected=\"selected\"";
		}
		echo">".$row[$labelFieldName]."</option>";
	}
	echo "</select></td></tr>";
}
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}

//Start session
session_start();
	
//Check whether the session variable SESS_MEMBER_ID is present or not
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == ''))
{
	echo "<p>Hey, you're not logged in!!!!</p>";
    echo "<p>Click <a href=\"login.php\">here</a> to get logged in.</p>";
	exit();
}
else if(!isset($_SESSION['SESS_DATE']) || !isset($_SESSION['SESS_ACCESSSTART']) || !isset($_SESSION['SESS_ACCESSEND']) || !isset($_SESSION['SESS_STOPDATE']) ||
        !isset($_SESSION['SESS_STARTTIME']) || !isset($_SESSION['SESS_ENDTIME']) || !isset($_SESSION['SESS_RECURRENCE']) || !isset($_SESSION['SESS_BUILDING']))
{
    header("location: searchByDate.php");
}
else
{
    $date = $_SESSION['SESS_DATE'];
    $accessStart = $_SESSION['SESS_ACCESSSTART'];
    $accessEnd = $_SESSION['SESS_ACCESSEND'];
    $startTime = $_SESSION['SESS_STARTTIME'];
    $endTime = $_SESSION['SESS_ENDTIME'];
    $recurrence = $_SESSION['SESS_RECURRENCE'];
    $stopDate = $_SESSION['SESS_STOPDATE'];
    $building = $_SESSION['SESS_BUILDING'];
    
    unset($_SESSION['SESS_DATE']);
    unset($_SESSION['SESS_ACCESSSTART']);
    unset($_SESSION['SESS_ACCESSEND']);
    unset($_SESSION['SESS_STARTTIME']);
    unset($_SESSION['SESS_ENDTIME']);
    unset($_SESSION['SESS_RECURRENCE']);
    unset($_SESSION['SESS_STOPDATE']);
    unset($_SESSION['SESS_BUILDING']);
}

?>
<body>
<h3>Reservation Time!</h3>
<form method="post">
<table border ='0'>
<?php
    // Connect to the sql database
	$con = mysql_connect("localhost","root");
	
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
    //****************************

	/*
	// Create and populate the Organziation field
	$result = mysql_query("SELECT Name FROM organization");
	echo "<tr><td>Organization:</td>
	          <td><select name=\"organization\">
			      <option value=\"default\">Select an Organization</option>";
	
	while($row = mysql_fetch_array($result))
	{
	    echo "<option value=\"".$row['Name']."\">".$row['Name']."</option>";
	}
	echo "</td></tr>";*/
	populateOptionList("Organization", "organization", "organization", "Name", "Name");
	populateOptionList("Primary Contact", "primaryContact", "User", "Name", "ID");
	populateOptionList("Alternate Contact", "altContact", "User", "Name", "ID");
	// *******************************************
	
	
?>


<!-- <tr><td>Organization:</td><td><input type="text" name="organization"></td></tr> 
<tr><td>Organization President:</td><td><input type="text" name="orgPres"></td></tr>
<tr><td>Oranization Advisor:</td><td><input type="text" name="orgAdvisor"></td></tr> 
<tr><td>Contact Name:</td><td><input type="text" name="name"></td></tr>
<tr><td>Phone Number:</td><td><input type="tel" name="phone"></td></tr>
<tr><td>Email:</td><td><input type="email" name="email"></td></tr>
<tr><td>Alternate Contact Name:</td><td> <input type="text" name="name2"></td></tr>
<tr><td>Phone Number:</td><td> <input type="tel" name="phone2"></td></tr>
<tr><td>Email:</td><td> <input type="email" name="email2"></td></tr> -->


<tr><td>Event Title:</td><td> <input type="text" name="eventTitle" maxlength="40"></td></tr>
<tr><td>Event Type:</td><td> <select name="eventType">
		<option value="meeting">Meeting</option>
		<option value="study">Study Session</option>
		<option value="performance">Performance</option>
		<option value="meal">Meal</option>
		<option value="seminar">Seminar</option>
		<option value="conference">Conference</option>
		<option value="sportingEvent">Sporting Event</option>
		<option value="banquet">Banquet</option>
		<option value="fundraiser">Fundraiser</option>
		<option value="informationTable">Information Table</option>
		<option value="other">Other</option>
	</select></td></tr>
<tr><td>Event Date:</td><td> <input type="date" name="date"></td></tr>
<tr><td>Access Time:</td><td> <input type="time" name="accessStart"> to <input type="time" name="accessEnd"></td></tr>
<tr><td>Event Time:</td><td> <input type="time" name="startTime"> to <input type="time" name="endTime"></td></tr>
<tr><td>Event Description:</td><td> </br> <textarea rows="10" cols="50" name="eventDesc"></textarea></td></tr>

<tr><td>&nbsp;</td></tr>
<?php
populateOptionList("First Choice of Facility", "firstChoiceRoom", "Room", "Name", "ID");
?>
<tr><td>Building:</td><td> <input type="text" name="building"></td></tr>
<tr><td>Room Number/Name:</td><td> <input type="text" name="room"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>2nd Choice of Facility</td></tr>
<tr><td>Building:</td><td> <input type="text" name="room"></td></tr>
<tr><td>Room Number/Name:</td><td> <input type="text" name="room"></td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td>Expected Number of Participants:</td><td> <input type="number" name="participants"></td></tr>
<tr><td>Will tickets be sold?</td><td> 
	<input type="radio" name="ticketsCheck" value=1> Yes 
	<input type="radio" name="ticketsCheck" value=0 checked="true"> No</td></tr>
<tr><td>Will prizes be awarded?</td><td>
	<input type="radio" name="prizesCheck" value=1> Yes 
	<input type="radio" name="prizesCheck" value=0 checked="true"> No</td></tr>
<tr><td>Will outside vendors sell goods at your event?</td><td>
	<input type="radio" name="vendorsCheck" value=1> Yes 
	<input type="radio" name="vendorsCheck" value=0 checked="true"> No</td></tr>
<tr><td>Will alcohol be served?</td><td>
	<input type="radio" name="alcoholCheck" value=1> Yes 
	<input type="radio" name="alcoholCheck" value=0 checked="true"> No</td></tr>
<tr><td>Will you have decorations?</td><td>
	<input type="radio" name="decorationsCheck" value=1> Yes 
	<input type="radio" name="decorationsCheck" value=0 checked="true"> No</td></tr>

</table>
<input type="submit" name = "submit" value = "Submit Request" />
	
</form>

<?php
    function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	// The following will NOT execute if the form is blank. (The user just entered the page)
	if(isset($_POST["submit"]))// == "Submit Query")
	{
        $userID = $_POST["primaryContact"];

	    // Initialize variables with user entered information
	    /*$organization = clean($_POST["organization"]);
		$orgPres = clean($_POST["orgPres"]);
		$orgAdvisor = clean($_POST["orgAdvisor"]);
	    $name = clean($_POST["name"]);
		$phone = clean($_POST["phone"]);
		$email = clean($_POST["email"]);
		$name2 = clean($_POST["name2"]);
		$phone2 = clean($_POST["phone2"]);
		$email2 = clean($_POST["email2"]);
		$eventTitle = clean($_POST["eventTitle"]);
		$eventType = clean($_POST["eventType"]);
		$date = clean($_POST["date"]);
		$accessStart = clean($_POST["accessStart"]);
		$startTime = clean($_POST["startTime"]);
		$eventDesc = clean($_POST["eventDesc"]);
		$building = clean($_POST["building"]);
		$room = clean($_POST["room"]);
		$participants = clean($_POST["participants"]);
		$ticketsCheck = clean($_POST["ticketsCheck"]);
		$prizesCheck = clean($_POST["prizesCheck"]);
		$vendorsCheck = clean($_POST["vendorsCheck"]);
		$alcoholCheck = clean($_POST["alcoholCheck"]);
		$descriptionsCheck = clean($_POST["descriptionCheck"]);*/
		/*
		// Connect to the sql database
	    $con = mysql_connect("localhost","root");
		
		if(!$con)
	    {
	    	die('Could not connect: ' . mysql_error());
	    }

	    mysql_select_db("r3", $con);
		
		$failure = 0;
		//Do validation here
		
		if(!$failure)
		{
		    $sql = "INSERT INTO USER VALUES ('$studentNumber', '$name', '$emailAddr', '$isAdmin', '$passwdHash')";
			
			if (!mysql_query($sql,$con))
 	        {
 	            die('Error: ' . mysql_error());
 	        }
	        echo "User Successfully Added <br>";
		}
		
		mysql_close($con);*/
	}
?>
</body>
</html>