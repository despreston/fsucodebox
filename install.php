<?php
////////////////////////////////////////////////////////////////////////////////
//THIS IS THE SETUP FILE FOR FSU CODE BOX.
//This will create the database and all tables and rows needed for the entire site.
//DO NOT alter anything besides the database info on the first line below:
////////////////////////////////////////////////////////////////////////////////

	$con = mysql_connect("localhost","root","yourpasswordhere");
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	//CREATE DATABASE
	$dbname = "fsucodebox2";
	if (mysql_query("CREATE DATABASE $dbname",$con))
	{
		echo "Database created";
		echo '<br />';
	}
	else
	{
		echo "Error creating database: " . mysql_error();
		echo '<br />';
	}
		
	mysql_select_db($dbname, $con);
	
	//CREATE USER TABLE
	$create_user_table = "CREATE TABLE users (
		email varchar(30),
		password varchar(100),
		firstname varchar(30),
		lastname varchar(30),
		teacher int,
		user_id int NOT NULL AUTO_INCREMENT,
		PRIMARY KEY(user_id)
	)";
	if(mysql_query($create_user_table, $con)) {
		echo "User table created";
		echo '<br />';
	}
	else
	{
		echo "Error creating database: " . mysql_error();
		echo '<br />';
	}

	//CREATE UPLOAD TABLE
	$create_upload_table = "CREATE TABLE uploads (
		url varchar(120),
		upload_id int NOT NULL AUTO_INCREMENT,
		upload_name varchar(300),
		comment varchar(1000),
		student varchar(300),
		teacher varchar(300),
		date varchar(400),
		PRIMARY KEY(upload_id)
	)";
	if(mysql_query($create_upload_table, $con)) {
		echo "Upload table created";
		echo '<br />';
	}
	else
	{
		echo "Error creating database: " . mysql_error();
		echo '<br />';
	}

	
	mysql_close($con);
?>