<link rel="stylesheet" type="text/css" href="mystyles.css" media="screen" />
<script type="text/javascript" src="fix_page_height.js"></script>
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


<body>
<div id="wrap">
<a href="index.php"><img src="images/Logo_Reverse__356.jpg" height="136" width="151" alt="S&T logo" align="left" style="padding-right:30px;" /></a>
</br>
<h1 style="color:rgb(0,133,63)">R<sup>3</sup> Reservation System</h1>
<br clear="all"/>
<hr />

<div id="content" style="padding-top:50px;">

<h2 align="center">Login to the R3 System</h2>

<!-- *************** -->
<!-- GENERATE A FORM -->
<!-- *************** -->
<p align="center">Please Enter Your Information:</p>

<form method="post">
	<table align="center" rules="all" cellpadding="4" class="green">	
		<tr>
			<td><b>Email Address</b></td> 
			<td><input type="email" name="emailAddr" /></td>
		</tr>
		<tr>
			<td><b>Password</b></td>  
			<td><input type="password" name="passwd" /></td>
		</tr>
	</table>
	
	<p align="center">
	<input type="submit" name="submit" value="Log In" /> </p>
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
	if(isset($_POST["submit"]))
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
            echo "<p align=\"center\" style=\"color:red;\"> Password missing! </p>";
            $failure = 1;
        }
        $passwdHash = hash("sha256", clean($_POST["passwd"]));
        
        if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", $emailAddr)) {
            $failure = 1;
            echo "<p align=\"center\" style=\"color:red;\"> Invalid email address! </p>";
        }
		
        if(!$failure)
        {
            $sql = "SELECT * FROM user WHERE Email='$emailAddr' AND password_SHA256_hash='$passwdHash'";
            $result=mysql_query($sql);
            if($result)
            {
                if(mysql_num_rows($result) == 1) 
                {
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
                    echo "<p align=\"center\" style=\"color:red;\"> Login Failed! </p>";
                    exit();
                }
            }
		}
		
		mysql_close($con);
	}
?>
</div>
</body>
</html>
