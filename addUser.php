<html>
<?php
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
?>
	<head>
	<title>Add a User to the R3 System</title>
	</head>
	<body>
	<h1>Add a User to the R3 System</h1>
	<hr />

	<br><br><br><br>
    <!-- *************** -->
    <!-- GENERATE A FORM -->
    <!-- *************** -->
    Enter Information

	<form method="post">
	<table border ='1'>
	
	<tr>
	<td>Student Number </td> <td><input type="number" name="studentNumber" /> </td>
	</tr>
	
	<tr>
	<td>Name </td> 	<td><input type="text" name="name" /> </td>
	</tr>
	
	<tr>
	<td>Email Address </td> <td><input type="email" name="emailAddr" /> </td>
	</tr>

	<tr>
	<td>Password </td>  <td><input type="password" name="passwd" /> </td>
	</tr>
	
	<tr>
	<td>Are you an admin?</td>
	<td>
	<select name="isAdmin">
        <option value="0">No</option>
        <option value="1">Yes</option>
    </select>
	</td>
	</tr>
	</table>
	
	<input type="submit" name = "submit" value = "Submit Query" /> 
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

	    // Initialize variables with user entered information
	    $studentNumber = clean($_POST["studentNumber"]);
		$name = clean($_POST["name"]);
		$emailAddr = clean($_POST["emailAddr"]);
	    $passwdHash = hash("sha256", clean($_POST["passwd"]));
		$isAdmin = clean($_POST["isAdmin"]);
		
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
		
		mysql_close($con);
	}
?>
</body>
</html>
