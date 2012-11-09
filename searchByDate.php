<html>
<title>Search by Date</title>
<script type="text/javascript">
function changeToBuildingMap()
{
    var selectBox = document.getElementById("buildingSelect");
    var selectedValue = selectBox.options[selectBox.selectedIndex].value;
    document.getElementById('theImage').src="/" + selectedValue + ".png";
}
</script>
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

// Connect to the sql database
$con = mysql_connect("localhost","root");
	
if(!$con)
{
	die('Could not connect: ' . mysql_error());
}
	
mysql_select_db("r3", $con);
//****************************
?>

<body>
<h1>Time and Place for Reservation<h1>
<hr />
<form method="post">
<table border='0'>
<td>
<table border='0'>
    <tr><td>Event Date:</td><td> <input type="date" name="date"></td></tr>
    <tr><td>Access Time:</td><td> <input type="time" name="accessStart"> to <input type="time" name="accessEnd"></td></tr>
    <tr><td>Event Time:</td><td> <input type="time" name="startTime"> to <input type="time" name="endTime"></td></tr>
    <tr><td>Building:</td><td>
    <?php

	$result = mysql_query("SELECT name FROM building");
	
	echo "<select id=\"buildingSelect\" name=\"building\" onChange=\"changeToBuildingMap()\">
	          <option value=\"campusMap\">Select a Building</option>";
	
	while($row = mysql_fetch_array($result))
	{
	    echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
	}
    ?>
    </select></td></tr>
    <tr><td><input type="submit" name = "checkRoomAvailability" value = "Check Room Availability" /></td></tr>
    
</table>
</td>
<td>
<img id="theImage" src="campusMap.png" alt="Campus Map">
</td>
</table>

</form>
<?php
	// The following will NOT execute if the form is blank. (The user just entered the page)
	if(isset($_POST["checkRoomAvailability"]))// == "Submit Query")
	{

	    // Initialize variables with user entered information
	    $date        = $_POST["date"];
		$accessStart = $_POST["accessStart"];
        $accessEnd   = $_POST["accessEnd"];
		$startTime   = $_POST["startTime"];
        $endTime     = $_POST["endTime"];
	    $building    = $_POST["building"];
		
		$failure = 0;
		//Do validation here
        if($accessEnd < $accessStart)
        {
            echo "<p>Error, access end time is earlier than access start time</p>";
            $failure = 1;
        }
        
        if($startTime > $endTime)
        {
            echo "<p>Error, end time is earlier than start time</p>";
            $failure = 1;
        }
        
		if($accessEnd > $startTime)
        {
            echo "<p>Error, your access time is later than your start time</p>";
            $failure = 1;
        }
        
        if($building == "campusMap")
        {
            echo "<p>Error, you have not selected a building!</p>";
        }
        
		if(!$failure)
		{
            //Insert data into database here
		    /*$sql = "INSERT INTO USER VALUES ('$studentNumber', '$name', '$emailAddr', '$isAdmin', '$passwdHash')";
			
			if (!mysql_query($sql,$con))
 	        {
 	            die('Error: ' . mysql_error());
 	        }
	        echo "Reservation Successfully Added <br>";*/
		}
		
		mysql_close($con);
	}
?>

</body>
</html>