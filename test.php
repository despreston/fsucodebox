		<?php
		
	
 
/*********************************************
			Example of use
**********************************************/	
 
/* 
Make sure script execution doesn't time out.
Set maximum execution time in seconds (0 means no limit).
*/
set_time_limit(0);	
$file_path=$_GET['file_url'];
$download_name = $_GET['dl_name'];
output_file($file_path, '/uploads/pres4445@fredonia.edu/main.cpp', 'text/plain');
		
?> 