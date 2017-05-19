<?php
	session_name("2Org-Cows");
	session_start();
	session_destroy();	
	session_name("Logout");
	session_start();
	if (ini_get('session.use_cookies')) {
		session_set_cookie_params(time() - 42000,
			$path = "/",
			$domain = "org-cow-breeding.router_of_thomas",
			$secure = true,
			$httponly = true);
	}
	session_destroy();
	$val1 = "Thanks for visiting 2Org-Cows project site";
	header("Location: ..?val1=$val1");
	exit();
?>