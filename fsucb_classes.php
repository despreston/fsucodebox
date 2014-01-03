<?php
	require('connect.php');
	error_reporting(0);
	
	class fsu_codebox {

		function getDownload($filename) {
			$geturl = mysql_fetch_array(mysql_query("SELECT url FROM uploads WHERE upload_name = '$filename'"));
			return $geturl['url'];
		}
		
		function logIn($email, $password) { //check inputted password against password in database
			$check_creds = "SELECT password FROM users WHERE email='$email'";
			$blah = mysql_query($check_creds) or die(mysql_error());
			$row = mysql_fetch_array($blah);
			$salt = 's+(_a*';
			$hash = md5($password.$salt);
			echo $row['password'];
			echo '<br />';
			echo $hash;
			if($row['password'] == $hash) { //password matches succesfully, log user in
				return true;
			}
			else { //wrong password, return false
				return false;
			}
		}
		
		function isTeacher($email) {
			$check_teacher = mysql_query("SELECT teacher FROM users WHERE email='$email'");
			$get_teacher_value = mysql_fetch_array($check_teacher);
			if($get_teacher_value['teacher'] == 1) {
				return true;
			}
			else {
				return false;
			}
		}

		function getStudentUploads($email) {
			$uploadlist = mysql_query("SELECT * FROM uploads WHERE student = '$email'");
			echo "<div class='uploads'><table cellspacing='0'>
			<tr id='table_title'>										
			<th>Filename</th>									
			<th>Teacher</th>
			<th>Comment</th>
			<th>Date Uploaded</th>
			</tr>";
			while($convertuploadlist = mysql_fetch_array($uploadlist)) {
				echo "<tr>";
				echo "<td><a href=/fsucodebox/" . $convertuploadlist['url']." target='_blank' >" . $convertuploadlist['upload_name'] . "</a><a href='download.php?file_name=".$convertuploadlist['upload_name']."' target='_blank'> (Download)</a></td>";
				$teacher = $convertuploadlist['teacher'];
				$getteacher = mysql_query("SELECT firstname, lastname FROM users WHERE email='$teacher'");
				$showteacher = mysql_fetch_array($getteacher);
				echo "<td>" . $showteacher['lastname']. ", ". $showteacher['firstname'] . "</td>";
				if($convertuploadlist['comment'] == NULL) { 
					echo "<td align='center'>No</td>";
				}
				else { 
					echo "<td align='center'><a href='javascript:showComment(".$convertuploadlist['upload_id'].")'>Yes</a></td>";
				}
				echo "<td>" . $convertuploadlist['date'] . "</td>";
				echo "</tr>";
			}
			echo "</table></div>";
		}

		function getTeacherUploads($email) {
			$uploadlist = mysql_query("SELECT * FROM uploads WHERE teacher = '$email'");
			echo "<div class='uploads'><table cellspacing='0'>
			<tr id='table_title'>										
			<th>Filename</th>									
			<th>Student</th>
			<th>Comment</th>
			<th>Date Uploaded</th>
			</tr>";
			while($convertuploadlist = mysql_fetch_array($uploadlist)) {
				echo "<tr>";
				echo "<td><a href=/fsucodebox/" . $convertuploadlist['url']." target='_blank' >" . $convertuploadlist['upload_name'] . "</a><a href='download.php?file_name=".$convertuploadlist['upload_name']."' target='_blank'> (Download)</a></td>";
				$student = $convertuploadlist['student'];
				$getstudent = mysql_query("SELECT firstname, lastname FROM users WHERE email='$student'");
				$showstudent = mysql_fetch_array($getstudent);
				echo "<td>" . $showstudent['lastname']. ", ". $showstudent['firstname'] . "</td>";
				if($convertuploadlist['comment'] == NULL) { 
					echo "<td align='center'><a href='javascript:createWindow(".$convertuploadlist['upload_id'].")'>No</a></td>";
				}
				else { 
					echo "<td align='center'><a href='javascript:createWindow(".$convertuploadlist['upload_id'].")'>Yes</a></td>";
				}
				echo "<td>" . $convertuploadlist['date'] . "</td>";
				echo "</tr>";
				echo "</tr>";
			}
			echo "</table></div>";
		}
		
		function getComment($comment_id) {
			$getcomment = mysql_fetch_array(mysql_query("SELECT comment,upload_name FROM uploads WHERE upload_id = '$comment_id'"));
			echo '<h3>Comment ('.$getcomment['upload_name'].'):</h3> <br />'.$getcomment['comment'];
		}
		
		function register($first, $last, $email, $pass, $check) {
			if($_POST['firstName'] == NULL || $_POST['lastName'] == NULL || strlen($_POST['emailAddress']) < 3 || strlen($_POST['pass']) < 5)
			{
				echo("Please make sure all fields are filled ");
				echo '<a href="registration.php">Go back</a>';
			}
			else
			{
				//Validation
				if (!preg_match("#[A-Z0-9_]+#i", $first)) {
						echo "Firstname contains invalid characters, may only contain alphanumeric characters including underscores!";
						die();
				}
				if (!preg_match("#[A-Z0-9_]+#i", $last)) {
						echo "Lastname contains invalid characters, may only contain alphanumeric characters including underscores!";
						die();
				}
				if (!preg_match("#[A-Z0-9_]+#i", $pass)) {
						echo "Password contains invalid characters, may only contain alphanumeric characters including underscores!";
						die();
				}
				$first = mysql_real_escape_string($first);
				$last = mysql_real_escape_string($last);
				$pass = mysql_real_escape_string($pass);
				$check_doubles = mysql_query("SELECT * FROM users");
				$taken=false;
				//CHECK FOR DUPLICATE REGISTERED NAMES
				while($row = mysql_fetch_array($check_doubles))
				{
					if($email == $row['email'])
					{
						echo("This email has already been registered");
						echo "<br /><a href=\"registration.php\">Back</a>";
						$taken=true;
					}
				}
				//IF NO DUPLICATES, REGISTER USER
				if($taken == false) {
					$salt = 's+(_a*';
					$hash = md5($pass.$salt);
					mkdir(".\\uploads\\".$email, 0777);					
					$result = mysql_query("INSERT INTO users (email,password,firstname,lastname,teacher) VALUES ('$email','$hash','$first','$last','$check')");
					$result2 = mysql_query("SELECT firstname FROM users WHERE email ='$email'");
					$row = mysql_fetch_array($result2);
					echo 'Thanks for registering '.$row['firstname'];
					echo '<h2>Thanks!</h2>';
					echo '<h3>You\'re all set</h3>';
					echo '<p>Registration is all done. Click <a href="index.php">here</a> to head back to the homepage and log in.</p>';
				}
			}
		}
		
		function getTeachers() {
			$options = "";
			$teacher = mysql_query("SELECT firstname,lastname,email FROM users WHERE teacher='1' ORDER BY lastname");
			echo '<SELECT NAME=teacher>';
			echo '<OPTION VALUE=0>Choose';
			while($row = mysql_fetch_array($teacher))
			{
				$options ='<OPTION VALUE='.$row['email'].'>'.$row['lastname'].', '.$row['firstname']; 
				echo $options;
			}
			echo '</SELECT>';
		}
		
		function addComment($comment,$comment_id) {
			$deleteold = mysql_query("DELETE comment FROM uploads WHERE comment='$comment'");
			$add = mysql_query("UPDATE uploads SET comment = '$comment' WHERE upload_id = '$comment_id'");
		}
		
		function uploadCode($email,$file,$teacher) {	
			
			function findexts ($filename) 
			{ 

			$filename = strtolower($filename) ; 

			$exts = split("[/\\.]", $filename) ; 

			$n = count($exts)-1; 

			$exts = $exts[$n]; 

			return $exts; 

			}
			if ((findexts($file["name"])=="php") || (findexts($file["name"])=="txt") || 
			(findexts($file["name"])=="cpp") || (findexts($file["name"])=="c") || 
			(findexts($file["name"])=="h") || (findexts($file["name"])=="zip") || (findexts($file["name"])=="htm") ||
			(findexts($file["name"])=="html") || (findexts($file["name"])=="css"))
			  {
			  if ($_FILES["file"]["error"] > 0)
				{
					echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
				}
			  else
				{
					//echo "Upload: " . $_FILES["file"]["name"] . "<br />";
					//echo "Type: " . $_FILES["file"]["type"] . "<br />";
					//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
					//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";

					if (file_exists("uploads\\" .$email."\\". $_FILES["file"]["name"].'.txt'))
					  {
						echo $_FILES["file"]["name"] . " already exists. Please rename your file to something unique and then try again.";
					  }
					else
					  {
						if(findexts($file["name"])=="zip") {
							$url = ("uploads/" .$email."/". $_FILES["file"]["name"]);
						}
						else {
							$url = ("uploads/" .$email."/". $_FILES["file"]["name"].'.txt');
						}
						move_uploaded_file($_FILES["file"]["tmp_name"],
						$url);
						$uploadname = $_FILES['file']['name'];
						$date = date('jS \of F Y h:i:s A');
						$updatedatabase = mysql_query("INSERT INTO uploads (url,student,teacher,upload_name,date) VALUES ('$url','$email','$teacher','$uploadname','$date')");
						if(!$updatedatabase) { 
							echo ("Failed to update upload database");
						}
					  }
				}
			  }
			else
			  {
			  echo "Invalid file";
			  }

		}
		
		 function output_file($file, $name, $mime_type='')
		{
		 if(!is_readable($file)) die('File not found or inaccessible!');
		 
		 $size = filesize($file);
		 $name = rawurldecode($name);
		 
		 /* Figure out the MIME type (if not specified) */
		 $known_mime_types=array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg"=> "image/jpg",
			"jpg" =>  "image/jpg",
			"php" => "text/plain"
		 );
		 
		 if($mime_type==''){
			 $file_extension = strtolower(substr(strrchr($file,"."),1));
			 if(array_key_exists($file_extension, $known_mime_types)){
				$mime_type=$known_mime_types[$file_extension];
			 } else {
				$mime_type="application/force-download";
			 };
		 };
		 
		 @ob_end_clean(); //turn off output buffering to decrease cpu usage
		 
		 // required for IE, otherwise Content-Disposition may be ignored
		 if(ini_get('zlib.output_compression'))
		  ini_set('zlib.output_compression', 'Off');
		 
		 header('Content-Type: ' . $mime_type);
		 header('Content-Disposition: attachment; filename="'.$name.'"');
		 header("Content-Transfer-Encoding: binary");
		 header('Accept-Ranges: bytes');
		 
		 /* The three lines below basically make the 
			download non-cacheable */
		 header("Cache-control: private");
		 header('Pragma: private');
		 header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		 
		 // multipart-download and download resuming support
		 if(isset($_SERVER['HTTP_RANGE']))
		 {
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			if(!$range_end) {
				$range_end=$size-1;
			} else {
				$range_end=intval($range_end);
			}
		 
			$new_length = $range_end-$range+1;
			header("HTTP/1.1 206 Partial Content");
			header("Content-Length: $new_length");
			header("Content-Range: bytes $range-$range_end/$size");
		 } else {
			$new_length=$size;
			header("Content-Length: ".$size);
		 }
		 
		 /* output the file itself */
		 $chunksize = 1*(1024*1024); //you may want to change this
		 $bytes_send = 0;
		 if ($file = fopen($file, 'r'))
		 {
			if(isset($_SERVER['HTTP_RANGE']))
			fseek($file, $range);
		 
			while(!feof($file) && 
				(!connection_aborted()) && 
				($bytes_send<$new_length)
				  )
			{
				$buffer = fread($file, $chunksize);
				print($buffer); //echo($buffer); // is also possible
				flush();
				$bytes_send += strlen($buffer);
			}
		 fclose($file);
		 } else die('Error - can not open file.');
		 
		die();
		}
		
		
	}
		

?>
	