<?php
	require('connect.php');
	require('fsucb_classes.php');
	session_start();
	$test = new fsu_codebox();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" /> 
	<title>FSU Code Box | Register</title>
	<link rel="stylesheet" href="style.css" type="text/css" media="all" /> 
	<link rel="stylesheet" href="mini_styles.css" type="text/css" media="all" /> 
	
<script type="text/javascript">
function passwordstrength () {
 min_name=0 ; min_screenname=2; min_password=4;
 a="";
 b="";
 d="Password must be at least 5 characters";
 fname_check=document.getElementById('firstName').value ;
 lname_check=document.getElementById('lastName').value ;
 pass_check=document.getElementById('pass').value ;
   if (fname_check.length>min_name) {
       a="<font color='#22bb22'>OK</font>";
	   submit_button=true;
    }
	if (lname_check.length>min_name) {
       b="<font color='#22bb22'>OK</font>";
	   submit_button=true;
    }
    if (pass_check.length>min_password) {
       d="<font color='#22bb22'>OK</font>";
	   submit_button=true;
    }
    document.getElementById('first_name_check').innerHTML=a ;
	document.getElementById('last_name_check').innerHTML=b ;
    document.getElementById('password_check').innerHTML=d ;

}
</script>	
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
		</ul>
	</div>
<!--
	MIKE THIS PART IS FOR YOU TO EDIT. DO NOT CHANGE ANY OF THE TAGS BELOW OR ABOVE AND DONT DELETE DIV CLASS PAGE.
	USE <H2>'S AND <P>'S FOR NOW. IN CLOSE THE IMAGE ON THE RIGHT UNDER THE NORMAL <IMG> AND MY CODE SHOULD DO THE REST
!-->
	<div class="page">
<?php
	if(!isset($_POST['submit'])) {
?>
		<h2>Sign Up!</h2>
		<h3>Fill Out Your Information:</h3>
		<div class="registration">
		<form name="registration" action="registration.php" method="POST">
			<ul>
				<li>First Name: <input type="text" id="firstName" name="firstName" onkeyup='Javascript:passwordstrength()'></input><div class="checker" id="first_name_check"></div></li>
				<li>Last Name: <input type="text" id="lastName" name="lastName" onkeyup='Javascript:passwordstrength()'></input><div class="checker" id="last_name_check"></div></li>
				<li>Password: <input type="password" id="pass" name="pass" onkeyup='Javascript:passwordstrength()'></input><div class="checker" id="password_check">Password must be at least 5 characters</div></li>
				<li>Email: <input type="text" id="emailAddress" name="emailAddress"></input></li>
				<li>Teacher? <input type="checkbox" value="teacher" name="checkBox[]"></input></li>
				<li><input type="submit" name="submit" value="Register"></input></li>
			</ul>
		</form>
		</div>
<?php
	}
	else {
		$new_register = new fsu_codebox();
		if(!isset($_POST['checkBox'])) {
			$teacher = 0;
		} else { $teacher = 1; }
		$new_register->register($_POST['firstName'],$_POST['lastName'],$_POST['emailAddress'],$_POST['pass'],$teacher);
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
		</div>
	</div>
</div>
</body>
</html>