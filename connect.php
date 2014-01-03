<?php 
	$address = 'localhost';
	$username = 'root';
	$password = 'yourpasswordhere';
	$connect = mysql_connect($address, $username, $password);
	if (!$connect)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_select_db("fsucodebox", $connect);
?>