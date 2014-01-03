<?php
	require('fsucb_classes.php');
	session_start();
	$user = new fsu_codebox(); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<title>FSU Code Box | User Page</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="all" /> 
	<link rel="stylesheet" href="mini_styles.css" type="text/css" media="all" /> 
	<script language="JavaScript" type="text/javascript" src="javascript.js"></script> 	
</head>
<body>
<a id="home_link" href="index.php">Home</a>
<div class="content">
	<div class="mini_header">
		<ul>
			<li><a href="about.php"><img src="images/about.gif" onmouseover="this.src='images/abouthover.gif'" 
			onmouseout="this.src='images/about.gif'"/> </a></li>
			<li><a href="help.php"><img src="images/help.gif" onmouseover="this.src='images/helphover.gif'" 
			onmouseout="this.src='images/help.gif'"/> </a></li>
<?php 
//CHECKS IF THE USER HAS SUBMITTED THE FORM, OR IF USERNAME/PASSWORD ARE NULL
	if(!isset($_POST['submit']) || $_POST['username'] == NULL || $_POST['password'] == NULL)
	{
		//CHECKS IF USER HAS BEEN LOGGED IN BEFORE (SESSION HAS ALREADY BEEN SET). IF NOT, THE LOG IN PAGE IS CREATED
		if(!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] != true)
		{
?>
			<li id="loginform"><form action="about.php" method="POST">
				 Username: <input type="text" name="username"></input>
				 Password: <input type="password" name="password"></input>
				 <input type="submit" name="submit" value="Go!"></input>
			</li>
<?php
		}
	}
//IF THE USER HAS ALREADY SUBMITTED THE FORM, AND PASSWORD AND USERNAME ARE NOT NULL, IT WILL CHECK TO SEE IF PASSWORD IS CORRECT FOR THAT USERNAME
	else
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
		if($user->logIn($username,$password)) {
			header("Location:user_page.php");
			$_SESSION['logged_in'] = true;
			$_SESSION['username'] = $_POST['username'];
		}
		else {
?>
			<li id="loginform"><form action="about.php" method="POST">
				 Username: <input type="text" name="username"></input>
				 Password: <input type="password" name="password"></input>
				 <input type="submit" name="submit" value="Go!"></input>
			</li>
<?php
		}
		
	}
	//IF SESSION HAS BEEN SET, DISPLAY THE WELCOME PAGE
	if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] = true)
	{
?>
			<li>
				<a href="logout.php">Logout</a>
			</li>
		</ul>
	</div>
<!--
	MIKE THIS PART IS FOR YOU TO EDIT. DO NOT CHANGE ANY OF THE TAGS BELOW OR ABOVE AND DONT DELETE DIV CLASS PAGE.
	USE <H2>'S AND <P>'S FOR NOW. IN CLOSE THE IMAGE ON THE RIGHT UNDER THE NORMAL <IMG> AND MY CODE SHOULD DO THE REST
!-->
		<div class="page">
<?php
		if($user->isTeacher($_SESSION['username'])) {
//page content for teachers
?>
			<h2>Teacher</h2>
			<br /><br />
<?php $user->getTeacherUploads($_SESSION['username']); 
		}
		else {
//page content for students
?>
			<h2>Student</h2>
<?php
			if(isset($_POST['submit2']))
			{
				unset($_POST['submit2']);
				$user->uploadCode($_SESSION['username'],$_FILES['file'],$_REQUEST['teacher']);
			}
?>
		<div class="upload_form">
			<form action="user_page.php" method="post" enctype="multipart/form-data">
				<label for="file">Upload new file:</label>
				<input type="file" name="file" id="file" /> 
				<?php $user->getTeachers(); ?> 
				<input type="submit" name="submit2" value="Submit" />
			</form>
			<p>Supported filetypes: php, txt, cpp, h, c, zip, html, htm, css</p>
		</div>
		<br /><br />
		
		<div id="teacher_comment"></div>
<?php
		$user->getStudentUploads($_SESSION['username']);
		}
?>
		</div>
<?php
	include ('newcomment.php');
	
	}
	else {
?>
		<div class="page">
			<img src="images/code.gif" alt="code" />
			<h2>Whoa, there!</h2>
			<p>You gotta pay the troll toll if you wanna get that boy's soul.</p>
			<p>You also have to sign in.</p>
		</div>
<?php
	}
?>
</div>
	<div class="footer">
		<div id="contactus">
			<h2>Contact Us</h2>
			<p>test@gmail.com</p>
		</div>
		<div id="links">
			<h2>Links</h2>
			<p><a href="about.php">About</a></p>
			<p><a href="help.php">Help</a></p>
		</div>
		<div id="copywrite">
			<p>All SUNY Fredonia logos are trademarks of State University of New York at Fredonia</p>
			<p style="font-size:.6em;">v0.1</p>
		</div>
	</div>
</body>
</html>
		