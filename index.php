<?php
	if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
		$uri = 'https://';
	} else {
		$uri = 'http://';
	}
	$uri .= $_SERVER['HTTP_HOST'];
	//header('Location: '.$uri.'/xampp/');

        echo "<h1>Hello World!</h1>";
	echo "<p>Click <a href=\"/xampp\">Here</a> for some XAMPP Info</p>";
	exit;
?>
Something is wrong with the XAMPP installation :-(
