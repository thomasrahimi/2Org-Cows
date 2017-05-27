<?php
require_once 'session-handler.php';
	session_name("2Org-Cows");
	session_start();
	session_destroy();
	$val1 = "Thanks for visiting 2Org-Cows project site";
	header("Location: ..?val1=$val1");
	exit();
?>
