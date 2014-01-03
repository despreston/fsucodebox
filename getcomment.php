<?php
	session_start();
	require('fsucb_classes.php');
	$newobj = new fsu_codebox();
	$newobj->getComment($_GET['q']);
?>