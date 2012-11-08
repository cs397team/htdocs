<html>
<?php
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
?>

<head>
<title>Login to the R3 System</title>
</head>

<body bgcolor = "black" link = "white" vlink = "white" text="white">

<div align="center">
	
<h1 align="center" >Login to the R3 System</h1>
<hr />

<br><br><br><br>
<!-- *************** -->
<!-- GENERATE A FORM -->
<!-- *************** -->
Enter Information

<form method="post">
	<table border ='1'>
	
	<tr>
	<td>Email Address </td> <td><input type="email" name="emailAddr" /> </td>
	</tr>

	<tr>
	<td>Password </td>  <td><input type="password" name="passwd" /> </td>
	</tr>
	
	</table>
	
	<input type="submit" name = "submit" value = "Submit Query" /> 
</form>
	
<?php
    
    function clean($str) 
    {
		$str = @trim($str);
		if(get_magic_quotes_gpc())
        {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
    session_start();
    
	// The following will NOT execute if the form is blank. (The user just entered the page)
	if(isset($_POST["submit"]))// == "Submit Query")
	{

	    // Initialize variables with user entered information
		$emailAddr = clean($_POST["emailAddr"]);
	    $passwd = clean($_POST["passwd"]);
		
		// Connect to the sql database
	    $con = mysql_connect("localhost","root");
		
		if(!$con)
	    {
	    	die('Could not connect: ' . mysql_error());
	    }

	    mysql_select_db("r3", $con);
		
		$failure = 0;
		//Do validation here
        
        if($passwd == '') 
        {
            echo "<br>Password missing!";
            $failure = 1;
        }
        $passwdHash = hash("sha256", clean($_POST["passwd"]));
        
        if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", $emailAddr)) {
            $failure = 1;
            echo "<br>Invalid email address!";
        }
		
        if(!$failure)
        {
            $sql = "SELECT * FROM user WHERE Email='$emailAddr' AND password_SHA256_hash='$passwdHash'";
            $result=mysql_query($sql);
             echo "$emailAddr<br>$passwdHash";
            if($result)
            {echo "<p>1</p>";
                if(mysql_num_rows($result) == 1) 
                {echo "<p>2</p>";
                    //Login Successful
                    session_regenerate_id();
                    $member = mysql_fetch_assoc($result);
                    $_SESSION['SESS_STUDENT_ID'] = $member['ID'];
                    $_SESSION['SESS_NAME'] = $member['Name'];
                    $_SESSION['SESS_ISADMIN'] = $member['isAdmin'];
                    $_SESSION['SESS_EMAIL'] = $member['Email'];
                    session_write_close();
                    
		    if( $member['isAdmin'] == 1 )
		    {
			header("location: admin-index.php");
		    }
		    else
		    {
			header("location: member-index.php");
		    }
		    
                    exit();
                }
                else 
                {
                    //Login failed
                    //header("location: login-failed.php");
                    echo "<br>Login Failed!";
                    exit();
                }
            }
		}
		
		mysql_close($con);
	}
?>
</body>
</html>
