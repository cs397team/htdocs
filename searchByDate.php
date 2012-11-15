<html>
<title>Search by Date</title>

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
<form action="searchByDate.php" method="post">
<table border='0'>
<td>
<table border='0'>
    <tr><td>Event Date:</td><td> <input type="date" name="date"></td></tr>
    <tr><td>Access Time:</td><td> <input type="time" name="accessStart"> to <input type="time" name="accessEnd"></td></tr>
    <tr><td>Event Time:</td><td> <input type="time" name="startTime"> to <input type="time" name="endTime"></td></tr>
    <tr><td>How often will this event occur?</td><td>
    <select name="recurrence" onChange="this.form.submit()">
    <?php
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "once")
            echo "selected=\"selected\" ";
        echo "value=\"once\">Once</option>";
           
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "daily")
               echo "selected=\"selected\" ";
        echo "value=\"daily\">Daily</option>";
           
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "weekly")
            echo "selected=\"selected\" ";
        echo "value=\"weekly\">Weekly</option>";
           
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "biWeekly")
            echo "selected=\"selected\" ";
        echo "value=\"biWeekly\">Bi-Weekly</option>";
    ?>
    </select></td></tr>
    <?php
        if( isset($_POST['recurrence']) && $_POST['recurrence'] != "once")
	        echo "<tr><td>Until:</td><td><input type=\"date\" name=\"stopDate\"></td></tr>";
    ?>
    <tr><td>Building:</td><td>
    <select name="building" onChange="this.form.submit()">
        <option value="campusMap.png">Select a Building</option>
    <?php

	$result = mysql_query("SELECT name FROM building");
		
	while($row = mysql_fetch_array($result))
	{
        $result2 = mysql_query("SELECT f1.floorImageURL, f1.floorNum FROM floor AS f1, building AS b1 WHERE f1.buildingName = b1.name");
        while($row2 = mysql_fetch_array($result2))
        {
            if($row2['floorNum'] == "2" /*!!!!!REPLACE WITH 1 WHEN WE COMPLETE THE DATABASE!!!!!*/)
            {
                if( isset($_POST['building']) && $_POST['building'] == $row['name'] )
                {
                    echo "<option selected=\"selected\" value=\"".$row['name']."\">".$row['name']."</option>";
                }
                else
                {
                    echo "<option value=\"".$row['name']."\">".$row['name']."</option>";
                }
            }
        }
	}
     
    echo "</select></td></tr>";
    
    if( isset($_POST['building']) )
    {
        echo " <tr><td>Floor:</td> <td><select name=\"floor\" onChange=\"this.form.submit()\">";
        
        $result = mysql_query("SELECT floorImageURL, floorNum FROM floor WHERE buildingName = '{$_POST['building']}'");
        while($row = mysql_fetch_array($result))
        {
            if(isset($_POST['floor']))
            {
                $floor = $_POST['floor'];
            }
            else
            {
                $floor = 2; /*CHANGE TO 1 WHEN DATABASE IS COMPLETE*/
            }
            
            if( $row['floorNum'] == $floor /*CHANGE TO 1 WHEN DATABASE IS COMPLETE*/)
            {
                echo "<option selected=\"selected\" value=\"".$row['floorNum']."\">".$row['floorNum']."</option>";
            }
            else
            {
                echo "<option value=\"".$row['floorNum']."\">".$row['floorNum']."</option>";
            }
        }
    
            
        echo "</select></td></tr>";
    }
?>
    <tr><td><input type="submit" name = "checkRoomAvailability" value = "Check Room Availability" /></td></tr>
    
</table>
</td>
<td>
<div style="position: relative; left: 0; top: 0;">
<?php
    
    if(isset($_POST['building']) && $_POST['building'] != "campusMap.png")
    {
        $result = mysql_query("SELECT floorNum, floorImageURL FROM floor WHERE buildingName = '{$_POST['building']}'");
        
        if(isset($_POST['floor']))
        {
            $floor = $_POST['floor'];
        }
        else
        {
            $floor = 2; /*CHANGE TO 1 WHEN DATABASE IS COMPLETE*/
        }
        
        while($row = mysql_fetch_array($result))
        {
            if( $row['floorNum'] == $floor)
            {
                echo "<img id=\"theImage\" src=\"{$row['floorImageURL']}\" style=\"position: relative; top: 0; left: 0;\" alt=\"Campus Map\" />";
                break;
            }
        }
    }
    else
    {
        echo "<img id=\"theImage\" src=\"images/campusMap.png\" style=\"position: relative; top: 0; left: 0;\" alt=\"Campus Map\" />";
    }
?>
<!-- TODO: Implement scheduling shading -->
<img hidden="hidden" src="images/cs_208_pending.png" style="position: absolute; top: 0; left: 0;" />
<img hidden="hidden" src="images/cs_209_pending.png" style="position: absolute; top: 0; left: 0;" />
</div>
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
        $recurrence  = $_POST["recurrence"];
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