<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>

<html>
<title>Search by Date</title>

<script>
function selectAndSubmitForm(value)
{
    var chosenSelect = document.getElementById('floor');
    
    for(var i = 0, j = chosenSelect.options.length; i < j; i++)
    {
        if(chosenSelect.options[i].innerHTML == value)
        {
            chosenSelect.selectedIndex = i;
            break;
        }
    }
    document.forms["searchByDate"].submit();
}
</script>

<?php //"First Choice of Facility", "firstChoiceRoom", "Room", "Name", "ID"
function populateOptionList($labelString, $keyName, $floor) {

    $result = mysql_query("SELECT ID, buildingName, roomNumber, isReservable FROM room WHERE floorNum = '{$floor}' AND buildingName = '{$_POST['building']}'");
		
    echo "<tr><td>".$labelString.":</td>
    <td><select name=\"".$keyName."\" onChange=\"this.form.submit()\">
    <option value=\"default\">Select a value</option>";
                              
    while($row = mysql_fetch_array($result))
    {
        $result2 = mysql_query("SELECT r1.Approval, e1.eventTimeStart, e1.eventTimeEnd, e1.accessTimeStart, e1.accessTimeEnd, 
                               e1.date from event as e1, reservation as r1 where r1.eventID = e1.id AND r1.primaryRoomNumber = '{$row['ID']}'");
        
        $availability = "Available";
        while($row2 = mysql_fetch_array($result2))
        {
            if( strtotime($row2['date']) == strtotime($_POST['date']) && (
                (strtotime($row2['eventTimeStart']) >= strtotime($_POST['startTime']) && strtotime($row2['eventTimeStart']) <= strtotime($_POST['endTime'])) ||
                (strtotime($row2['eventTimeEnd']) >= strtotime($_POST['startTime']) && strtotime($row2['eventTimeEnd']) <= strtotime($_POST['endTime'])) ||
                (strtotime($row2['eventTimeStart']) <= strtotime($_POST['startTime']) && strtotime($row2['eventTimeEnd']) >= strtotime($_POST['endTime']))
                                                                                              /*Add stuff for access time*/
                                                                            ))
            {
                if($row2['Approval'] == "Pending")
                {
                    $availability = "Pending";
                }
                else if($row2['Approval'] == "Approved")
                {
                    $availability = "Unavailable";
                    break;
                }
            }
        }
        
        if(($availability == "Available" || $availability == "Pending") && $row['isReservable'] == 1)
        {
            echo "<option value=\"".$row['ID']."\"";
            if(isset($_POST[$keyName]) && $row['ID'] == $_POST[$keyName])
                echo " selected=\"selected\"";
            echo">{$row['buildingName']} {$row['roomNumber']} ({$availability})</option>";
        }
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
if(!isset($_SESSION['SESS_STUDENT_ID']) || (trim($_SESSION['SESS_STUDENT_ID']) == '')) {
	header("location: login.php");
}

// Connect to the sql database
$con = mysql_connect("localhost","root");
	
if(!$con)
{
	die('Could not connect: ' . mysql_error());
}
	
mysql_select_db("r3", $con);
//****************************
    
    $problems['eventDate']  = "None";
    $problems['accessTime'] = "None";
    $problems['eventTime']  = "None";
    $problems['until']      = "None";
    $problems['building']   = "None";
    
    if(isset($_POST['resubmit']) || isset($_POST['checkRoomAvailability']))
    {
        if($_POST['date'] == "")
        {
            $problems['eventDate'] = "Please select a valid date!";
        }
        
        if($_POST['accessEnd'] == "" || $_POST['accessStart'] == "" )
        {
            $problems['accessTime'] = "Please select access times!";
        }
        else if(strtotime($_POST['accessEnd']) < strtotime($_POST['accessStart']))
        {
            $problems['accessTime'] = "Please select an access end time that is NOT earlier than access start time!";
        }
        
        if($_POST['startTime'] == "" || $_POST['endTime'] == "" )
        {
            $problems['eventTime'] = "Please select event times!";
        }
        else if(strtotime($_POST['startTime']) > strtotime($_POST['endTime']))
        {
            $problems['eventTime'] = "Please select an end time that is NOT earlier than start time!";
        }
        else if(strtotime($_POST['accessEnd']) > strtotime($_POST['startTime']))
        {
            $problems['eventTime'] = "Please select an access time that is NOT later than your start time!";
        }
        
        if($_POST['building'] == "campusMap.png")
        {
            $problems['building'] = "Please select a building!";
        }
        
        if($_POST['recurrence'] != "Once" && !isset($_POST['stopDate']))
        {
            $problems['until'] = "Select a stop date for your recurrence!";
        }
    }

?>

<body>
<div id="wrap">
<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>

<div class="container" id="navbar">
	<ul id="anim">
	<li id="b0"><a class="navlink" href="member-index.php">Home</a></li>
	<li id="b1"><a class="navlink" href="viewProfile.php">View Profile</a></li>
	<li id="b2"><a class="navlink" href="reservations.php">Approved Reservations</a></li>
	<li id="b3" class="a0"><a class="navlink" href="pending.php">Pending Reservations</a></li>
	<li id="b4"><a class="navlink" href="searchByDate.php">Make a Reservation</a></li>
	<li id="b5" style="border-right:1px solid #1f1f1f;"><a class="navlink" href="logout.php">Log Out</a></li>
	</ul>
</div>

<div id="content" style="padding-top:100px;">

<form id="searchByDate" action="searchByDate.php" method="post">
<table border='0'>
<td>
<table border='0'>
    <tr><td>Event Date:</td>
    <td> 
    <?php
        echo "<input";
        if( isset($_POST['date']) )
            echo " value=\"{$_POST['date']}\"";
        echo " type=\"date\" name=\"date\">";
        
        if($problems['eventDate'] != "None")
        {
            echo "</td></tr><tr><td></td><td><font color=\"red\">{$problems['eventDate']}</font>";
        }
    ?>
    </td></tr>
    <tr><td>Access Time:</td>
    <td> 
    <table border='0'>
    <tr><td>Start</td>
    <?php
        echo "<td><input";
        if( isset($_POST['accessStart']) )
            echo " value=\"{$_POST['accessStart']}\"";
        echo " type=\"time\" name=\"accessStart\"></td>"; 
        
        echo "</tr><tr><td>End</td>";
        
        echo "<td><input";
        if( isset($_POST['accessEnd']) )
            echo " value=\"{$_POST['accessEnd']}\"";
        echo " type=\"time\" name=\"accessEnd\"></td>";
        ?>
    </tr></table>
   <?php 
       if($problems['accessTime'] != "None")
       {
           echo "</td></tr><tr><td></td><td><font color=\"red\">{$problems['accessTime']}</font>";
       }   
    ?></td></tr>
    <tr><td>Event Time:</td>
    <td> 
    <table border='0'>
    <tr><td>Start</td>
    <?php
        echo "<td><input";
        if( isset($_POST['startTime']) )
            echo " value=\"{$_POST['startTime']}\"";
        echo " type=\"time\" name=\"startTime\"></td>";
        
        echo "</tr><tr><td>End</td>";
        
        echo "<td><input";
        if( isset($_POST['endTime']) )
            echo " value=\"{$_POST['endTime']}\"";
        echo " type=\"time\" name=\"endTime\"></td>";
        ?>
    </tr></table>
<?php
    if($problems['eventTime'] != "None")
    {
        echo "</td></tr><tr><td></td><td><font color=\"red\">{$problems['eventTime']}</font>";
    }
    ?>
    </td></tr>
    <tr><td>How often will this event occur?</td><td>
    <select name="recurrence" onChange="this.form.submit()">
    <?php
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "Once")
            echo "selected=\"selected\" ";
        echo "value=\"Once\">Once</option>";
           
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "Daily")
               echo "selected=\"selected\" ";
        echo "value=\"Daily\">Daily</option>";
           
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "Weekly")
            echo "selected=\"selected\" ";
        echo "value=\"Weekly\">Weekly</option>";
           
        echo "<option ";
        if(isset($_POST['recurrence']) && $_POST['recurrence'] == "Bi-Weekly")
            echo "selected=\"selected\" ";
        echo "value=\"Bi-Weekly\">Bi-Weekly</option>";
    ?>
    </select></td></tr>
    <?php
        if( isset($_POST['recurrence']) && $_POST['recurrence'] != "Once")
        {
            echo "<tr><td>Until:</td><td><input";
            if( isset($_POST['stopDate']) )
                echo " value=\"{$_POST['stopDate']}\"";
            echo " type=\"date\" name=\"stopDate\"></td></tr>";
            if($problems['until'] != "None")
            {
                echo "<tr><td></td><td><font color=\"red\">{$problems['until']}</font></td></tr>";
            }
        }
    ?>
    <tr><td>Building:</td><td>
    <select name="building" onChange="this.form.submit()">
        <option value="campusMap.png">Select a Building</option>
    <?php

	$result = mysql_query("SELECT name FROM building");
		
	while($row = mysql_fetch_array($result))
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
     
    echo "</select></td></tr>";
    if($problems['building'] != "None")
    {
        echo "<tr><td></td><td><font color=\"red\">{$problems['building']}</font></td></tr>";
    }
    
    if( isset($_POST['building']) && $_POST['building'] != "campusMap.png" )
    {
        echo " <tr><td>Floor:</td> <td><select id=\"floor\" name=\"floor\" onChange=\"this.form.submit()\">";
        
        $result = mysql_query("SELECT floorImageURL, floorNum FROM floor WHERE buildingName = '{$_POST['building']}'");
        while($row = mysql_fetch_array($result))
        {
            if(isset($_POST['floor']))
            {
                $floor = $_POST['floor'];
                
            }
            else
            {
                $floor = 1;
            }
            
            if( $row['floorNum'] == $floor)
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
        
        if((isset($_POST['date']) && $_POST['date'] != "") && (isset($_POST['accessStart']) && $_POST['accessStart'] != "") && 
           (isset($_POST['accessEnd']) && $_POST['accessEnd'] != "") && (isset($_POST['startTime']) && $_POST['startTime'] != "") && 
           (isset($_POST['endTime']) && $_POST['endTime'] != "") && (isset($_POST['building']) && $_POST['building'] != "") && 
           (isset($_POST['recurrence']) && $_POST['recurrence'] != "") && (isset($floor) && $floor != "") && 
           ((isset($_POST['stopDate']) && $_POST['stopDate'] != "") || $_POST['recurrence'] == "Once"))
    {
        populateOptionList("First Choice of Facility", "firstChoiceRoom", $floor);
    }
    else
    {
        echo "<tr><td>First Choice of Facility:</td><td><select><option>*Still Need to Fill Out All Fields</option></select></td></tr>";
    }
    
    if( isset($_POST['building']) && isset($_POST['recurrence']) && (isset($_POST['stopDate']) || $_POST['recurrence'] == "Once") &&
        isset($_POST['floor']) && isset($_POST['firstChoiceRoom']) && $_POST['firstChoiceRoom'] != "default")
    {
        echo "<tr><td><input type=\"submit\" name = \"checkRoomAvailability\" value = \"Go to Next Step\" /></td></tr>";
    }
    else
    {
        echo "<tr><td><input type=\"submit\" name = \"resubmit\" value = \"Check Availability\" /></td></tr>";
        echo "<tr><td><input disabled=\"disabled\" type=\"submit\" name = \"checkRoomAvailability\" value = \"Go to Next Step\" /></td></tr>";
    }
    ?>
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
            $doesFloorExist = mysql_query("SELECT floorNum FROM floor WHERE buildingName = '{$_POST['building']}' AND floorNum = '{$_POST['floor']}'");
            if(mysql_num_rows($doesFloorExist))
            {
                $floor = $_POST['floor'];
            }
            else
            {
                $floor = 1;
                echo "<script>selectAndSubmitForm({$floor});</script>";
            }
        }
        else
        {
            $floor = 1;
        }
        
        while($row = mysql_fetch_array($result))
        {
            if( $row['floorNum'] == $floor)
            {
                echo "<img id=\"theImage\" src=\"{$row['floorImageURL']}\" style=\"position: relative; top: 0; left: 0;\" alt=\"Campus Map\" />";
                if( (isset($_POST['date']) && $_POST['date'] != "") && (isset($_POST['accessStart']) && $_POST['accessStart'] != "") && 
                    (isset($_POST['accessEnd']) && $_POST['accessEnd'] != "") && (isset($_POST['startTime']) && $_POST['startTime'] != "") && 
                    (isset($_POST['endTime']) && $_POST['endTime'] != "") )
                {
                    $result2 = mysql_query("SELECT ID, availableImageURL, notAvailableImageURL, pendingAvailableImageURL, isReservable FROM room WHERE 
                                           buildingName = '{$_POST['building']}' AND floorNum = '{$floor}'");
                    
                    while($row2 = mysql_fetch_array($result2))
                    {
                        //Get times from events where event goes with room that includes current room.
                        $result3 = mysql_query("SELECT r1.Approval, e1.eventTimeStart, e1.eventTimeEnd, e1.accessTimeStart, e1.accessTimeEnd, 
                                               e1.date from event as e1, reservation as r1 where r1.eventID = e1.id AND r1.primaryRoomNumber = '{$row2['ID']}'");
                        $roomShaded = "Available";                       
                        while($row3 = mysql_fetch_array($result3))
                        {
                            if( strtotime($row3['date']) == strtotime($_POST['date']) && (
                               (strtotime($row3['eventTimeStart']) >= strtotime($_POST['startTime']) && strtotime($row3['eventTimeStart']) <= strtotime($_POST['endTime'])) ||
                               (strtotime($row3['eventTimeEnd']) >= strtotime($_POST['startTime']) && strtotime($row3['eventTimeEnd']) <= strtotime($_POST['endTime'])) ||
                               (strtotime($row3['eventTimeStart']) <= strtotime($_POST['startTime']) && strtotime($row3['eventTimeEnd']) >= strtotime($_POST['endTime']))
                                /*Add stuff for access time*/
                                                                                          ))
                            {
                                if( $row3['Approval'] == "Approved" )
                                {
                                    $roomShaded = "Not Available";
                                    break;
                                }
                                else if( $row3['Approval'] == "Pending" )
                                {
                                    $roomShaded = "Pending";
                                }
                            }
                        }

                        if( $roomShaded == "Available" && $row2['isReservable'] == 1)
                        {
                            echo "<img src=\"{$row2['availableImageURL']}\" style=\"position: absolute; top: 0; left: 0;\" />";
                        }
                        else if( $roomShaded == "Not Available" || $row2['isReservable'] == 0)
                        {
                            echo "<img src=\"{$row2['notAvailableImageURL']}\" style=\"position: absolute; top: 0; left: 0;\" />";
                        }
                        else if( $roomShaded == "Pending" && $row2['isReservable'] == 1)
                        {
                            echo "<img src=\"{$row2['pendingAvailableImageURL']}\" style=\"position: absolute; top: 0; left: 0;\" />";
                        }
                    }
                }
                break;
            }
        }
    }
    else
    {
        echo "<img id=\"theImage\" src=\"images/campusMap.png\" style=\"position: relative; top: 0; left: 0;\" alt=\"Campus Map\" />";
    }
        
?>
</div>
</td>
</table>
</div>
</form>
<br/>
<?php
	// The following will NOT execute if the form is blank. (The user just entered the page)

    if( isset($_POST['checkRoomAvailability']) && $problems['eventDate'] == "None" && $problems['accessTime'] == "None" && $problems['eventTime'] == "None" &&
       $problems['until'] == "None" && $problems['building'] == "None")
    {
        if( isset($_POST['date']) && isset($_POST['accessStart']) && isset($_POST['accessEnd']) && isset($_POST['startTime']) && isset($_POST['endTime']) && 
           isset($_POST['building']) && isset($_POST['recurrence']) && (isset($_POST['stopDate']) || $_POST['recurrence'] == "Once") && isset($_POST['firstChoiceRoom']) && 
           $_POST['firstChoiceRoom'] != "default")
        {
            //session_regenerate_id();
            $_SESSION['SESS_DATE'] = $_POST["date"];
            $_SESSION['SESS_ACCESSSTART'] = $_POST["accessStart"];
            $_SESSION['SESS_ACCESSEND'] = $_POST["accessEnd"];
            $_SESSION['SESS_STARTTIME'] = $_POST["startTime"];
            $_SESSION['SESS_ENDTIME'] = $_POST["endTime"];
            $_SESSION['SESS_RECURRENCE'] = $_POST["recurrence"];
            $_SESSION['SESS_STOPDATE'] = "";
            $_SESSION['SESS_FIRSTCHOICEROOM'] = $_POST["firstChoiceRoom"];
                
            if(isset($_POST['stopDate']))
            {
                $_SESSION['SESS_STOPDATE'] = $_POST["stopDate"];
            }
            
            mysql_close($con);
            echo "<meta HTTP-EQUIV=\"REFRESH\" content=\"0; url=reserve.php\">";
		}
        else
        {
            echo "<p align=\"center\" style=\"color:red\">You are missing some information!  Review the form and insure everything is filled out.</p>";
        }
		
	}
    mysql_close($con);
?>
</div>
</body>
</html>