<?php
session_name("2Org-Cows");
session_start();
$now = date("U");
	if(!isset($_SESSION) || 
	$_SERVER["REMOTE_ADDR"] != $_SESSION["ip"] || 
	$_SERVER["HTTP_USER_AGENT"] != $_SESSION["user_agent"] ||
	!isset($_SESSION["userid"])) {
		session_destroy();
		$val1 = "Session terminated due to security concerns. Please check your internet connection";
		header("Location: .?val1=$val1");
		exit;
	}
	elseif($now > $_SESSION["expire"]) {
		$val2 = "Session has timed out, please login again";
		session_destroy();
		header("Location: .?val2=$val2");
		exit;
	}
?>