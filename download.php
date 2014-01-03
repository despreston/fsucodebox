<?php
session_start();
require('fsucb_classes.php');
$newdl = new fsu_codebox();
set_time_limit(0);	

$download_name = $_GET['file_name'];
$file = $newdl->getDownload($download_name);
$newdl->output_file($file, $download_name, 'text/plain');
		
?> 