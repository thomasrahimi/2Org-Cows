<?php
session_name("2Org-Cows");
session_start();
$user_role = $_SESSION["role"];
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
	elseif($user_role < 2) {
		$val2 = "You are not allowed to access this page";
		header("Location: ./home?val2=$val2");
		exit;
	}
	elseif($now > $_SESSION["expire"]) {
		$val3 = "Session has timed out, please login again";
		session_destroy();
		header("Location: .?val3=$val3");
		exit;
	}
?>