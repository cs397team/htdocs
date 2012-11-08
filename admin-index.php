<html>
<?php
if($_SERVER['SERVER_PORT'] != '443') 
{ 
    header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
}
?>

<head>
<title>Admin Area</title>
</head>

<body bgcolor = "black" link = "white" vlink = "white" text="white">

<div align="center">
	
<h1 align="center" >Administrator Area</h1>
<hr />
<form action=viewRequests.php method = "post">
	<input type = "submit" name = "viewRequests" style="width:200px; height:32px; font-size:22px;" value = "View Requests" />
</form>

</body>
</html>
