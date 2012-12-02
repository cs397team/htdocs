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
else if(!isset($_POST['submit']) && (!isset($_SESSION['SESS_DATE']) || !isset($_SESSION['SESS_ACCESSSTART']) || !isset($_SESSION['SESS_ACCESSEND']) || !isset($_SESSION['SESS_STOPDATE']) ||
        !isset($_SESSION['SESS_STARTTIME']) || !isset($_SESSION['SESS_ENDTIME']) || !isset($_SESSION['SESS_RECURRENCE']) || !isset($_SESSION['SESS_FIRSTCHOICEROOM'])))
{
    header("location: searchByDate.php");
}
else if(!isset($_POST['submit']))
{
    $date                = $_SESSION['SESS_DATE'];
    $accessStart         = $_SESSION['SESS_ACCESSSTART'];
    $accessEnd           = $_SESSION['SESS_ACCESSEND'];
    $startTime           = $_SESSION['SESS_STARTTIME'];
    $endTime             = $_SESSION['SESS_ENDTIME'];
    $recurrence          = $_SESSION['SESS_RECURRENCE'];
    $stopDate            = $_SESSION['SESS_STOPDATE'];
    $firstChoiceRoom     = $_SESSION['SESS_FIRSTCHOICEROOM'];
    
    unset($_SESSION['SESS_DATE']);
    unset($_SESSION['SESS_ACCESSSTART']);
    unset($_SESSION['SESS_ACCESSEND']);
    unset($_SESSION['SESS_STARTTIME']);
    unset($_SESSION['SESS_ENDTIME']);
    unset($_SESSION['SESS_RECURRENCE']);
    unset($_SESSION['SESS_STOPDATE']);
    unset($_SESSION['SESS_FIRSTCHOICEROOM']);
}
else
{
    $date                = $_POST['date'];
    $accessStart         = $_POST['accessStart'];
    $accessEnd           = $_POST['accessEnd'];
    $startTime           = $_POST['startTime'];
    $endTime             = $_POST['endTime'];
    $recurrence          = $_POST['recurrence'];
    $stopDate            = $_POST['stopDate'];
    $firstChoiceRoom     = $_POST['firstChoiceRoom'];
}

?>
<body>
<h3>Reservation Time!</h3>
<form method="post">

<table border ='0'>
<?php
    echo "<input name=\"date\" hidden=\"hidden\" value=\"{$date}\" />";
    echo "<input name=\"accessStart\" hidden=\"hidden\" value=\"{$accessStart}\" />";
    echo "<input name=\"accessEnd\" hidden=\"hidden\" value=\"{$accessEnd}\" />";
    echo "<input name=\"startTime\" hidden=\"hidden\" value=\"{$startTime}\" />";
    echo "<input name=\"endTime\" hidden=\"hidden\" value=\"{$endTime}\" />";
    echo "<input name=\"recurrence\" hidden=\"hidden\" value=\"{$recurrence}\" />";
    echo "<input name=\"stopDate\" hidden=\"hidden\" value=\"{$stopDate}\" />";
    echo "<input name=\"firstChoiceRoom\" hidden=\"hidden\" value=\"{$firstChoiceRoom}\" />";
    // Connect to the sql database
	$con = mysql_connect("localhost","root");
	
	if(!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	
	mysql_select_db("r3", $con);
    //****************************

	populateOptionList("Organization", "organization", "organization", "Name", "Name");
	populateOptionList("Primary Contact", "primaryContact", "User", "Name", "ID");
	populateOptionList("Alternate Contact", "altContact", "User", "Name", "ID");
	// *******************************************
	
	
?>

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
<tr><td>&nbsp;</td></tr>
<tr><td>2nd Choice of Facility</td>
<?php
    $result = mysql_query("SELECT ID, buildingName, roomNumber FROM room WHERE ID <> {$firstChoiceRoom}");
    
    echo "<td><select name=\"secondChoiceRoom\">
    <option value=\"default\">Select a value</option>";
    
    while($row = mysql_fetch_array($result))
    {
        echo "<option value=\"{$row['ID']}\"";
        echo">{$row['buildingName']} {$row['roomNumber']}</option>";
    }
    echo "</select></td></tr>";

    ?>

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
<tr><td>Will you have food?</td><td>
<input type="radio" name="foodCheck" value=1> Yes 
<input type="radio" name="foodCheck" value=0 checked="true"> No</td></tr>
<tr><td>Equiment Needed</td><td>
<select name = "equipmentNeeded" multiple="multiple">
<option value="Transparency Projector">Transparency Projector</option>
<option value="TV / DVD">TV / DVD</option>
<option value="Microphones">Microphones</option>
<option value="Easel">Easel</option>
<option value="Dry-Erase Board">Dry-Erase Board</option>
<option value="Tabletop Podium">Tabletop Podium</option>
<option value="Floor Podium">Floor Podium</option>
<option value="Dance Floor">Dance Floor</option>
<option value="Carousel Projector">Carousel Projector</option>
<option value="U.S. Flag">U.S. Flag</option>
<option value="MO Flag">MO Flag</option>
<option value="University Flag">University Flag</option></td></tr>
</select>


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
        if(!isset($_POST["primaryContact"]) || $_POST["primaryContact"] == "default")
        {
            $userID = "NULL";
        }
        else
        {
            $userID = clean($_POST["primaryContact"]);
            $userID = "'{$userID}'";
        }
        
        if(!isset($_POST["altContact"]) || $_POST["altContact"] == "default")
        {
            $altUserID = "NULL";
        }
        else
        {
            $altUserID = clean($_POST["altContact"]);
            $altUserID = "'{$altUserID}'";
        }

	    // Initialize variables with user entered information
        if(!isset($_POST["organization"]) || $_POST["organization"] == "default")
        {
            $organization = "NULL";
        }
        else
        {
            $organization = clean($_POST["organization"]);
            $organization = "'{$organization}'";
        }
        
        if(!isset($_POST["eventTitle"]) || $_POST["eventTitle"] == "")
        {
            $eventTitle = "NULL";
        }
        else
        {
            $eventTitle = clean($_POST["eventTitle"]);
            $eventTitle = "'{$eventTitle}'";
        }
        
		$eventType = clean($_POST["eventType"]);

        if( $stopDate == "" )
        {
            $stopDate = "NULL";
        }
        else
        {
            $stopDate = "'{$stopDate}'";
        }
        
        if( !isset($_POST['secondChoiceRoom']) || $_POST['secondChoiceRoom'] == "default" )
        {
            $secondChoiceRoom = "NULL";
        }
        else
        {
            $secondChoiceRoom = "'{$_POST['secondChoiceRoom']}'";
        }
        
        if(!isset($_POST["participants"]) || $_POST["participants"] == "")
        {
            $participants = "NULL";
        }
        else
        {
            $participants = clean($_POST["participants"]);
            $participants = "'{$participants}'";
        }
		$ticketsCheck = clean($_POST["ticketsCheck"]);
		$prizesCheck = clean($_POST["prizesCheck"]);
		$vendorsCheck = clean($_POST["vendorsCheck"]);
		$alcoholCheck = clean($_POST["alcoholCheck"]);
        $foodCheck = clean($_POST["foodCheck"]);
		$decorationsCheck = clean($_POST["decorationsCheck"]);
        
        if(!isset($_POST["equipmentNeeded"]) || $_POST["equipmentNeeded"] == "")
        {
            $equipmentNeeded = "NULL";
        }
        else
        {
            $equipmentNeeded = "'{$_POST['equipmentNeeded']}'";
        }
        
		
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
		    $sql = "INSERT INTO event VALUES (NULL, {$eventTitle}, '{$startTime}', '{$endTime}', '{$accessStart}', '{$accessEnd}', '{$date}', '{$recurrence}', {$stopDate}, {$participants}, 
                     '{$decorationsCheck}', '{$alcoholCheck}', '{$prizesCheck}', '{$ticketsCheck}', '{$vendorsCheck}', '{$foodCheck}', '{$eventType}' )";

			if (!mysql_query($sql,$con))
 	        {
 	            die('Error on Insert into Event: ' . mysql_error());
 	        }

            $result = mysql_query("SELECT MAX(ID) AS ID FROM event");
            $row = mysql_fetch_array($result);
            
            $sql = "INSERT INTO reservation VALUE ( NULL, {$userID}, {$altUserID}, {$organization}, {$equipmentNeeded}, '{$row['ID']}', '{$firstChoiceRoom}', {$secondChoiceRoom}, 'Pending')";
            if (!mysql_query($sql,$con))
 	        {
 	            die('Error on Insert into Reservation: ' . mysql_error());
 	        }
	        echo "Reservation Successfully Added <br>";
		}
		
		mysql_close($con);
	}
?>
</body>
</html>