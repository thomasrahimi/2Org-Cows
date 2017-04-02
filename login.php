<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	session_start();
	$session_id1 = session_id();
	session_destroy();
	session_start();
	$session_id2 = session_id();
	session_destroy();
	if($session_id1 == $session_id2) {
		$cookies_state = "2Org-Cows requires cookies, to work properly. By using 2Org-Cows, you agree with the usage of cookies";
	}
	else {
		$cookies_state = "Please enable cookies, to use 2Org-Cows";
	}
	include_once "./scripts/logdb_connect.php";
	if(isset($_SERVER["HTTP_USER_AGENT"])) {
		$user_agent_1 = $_SERVER["HTTP_USER_AGENT"];
		$user_agent= $db->real_escape_string($user_agent_1);
	}
	else {
		$user_agent = "unknown";
	}
	$user_ip_whole = $_SERVER['REMOTE_ADDR'];
	$user_ip_whole = $db->real_escape_string($user_ip_whole);
	$user_ip_array = explode(".", $user_ip_whole);
	$user_ip = "$user_ip_array[0]."."$user_ip_array[1]."."$user_ip_array[2]";
	$time = date("U"); //date in Unix-Time
	$sql = "INSERT INTO Log_Table (time, user_agent, user_ip) VALUES (?,?,?)";
	$stmt = $db->prepare($sql);
	$stmt->bind_param('iss',$time,$user_agent,$user_ip);
	$stmt->execute();
	$db->close();
	session_name('Login');
	session_set_cookie_params(60*30, "/", $domain = "org-cow-breeding.router_of_thomas", $secure = true, $httponly = true);
	session_start();
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css"/>
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<title>Login</title>
</head>
<body>
	<div class="page">
	<div class="text a">
		<header class="header">
		Welcome - Please login to continue
		</header>
		<div class="logo">
			<picture>
	 		<source srcset="./static/Logo-2Org-Cows.png" media="(min-width: 800px)">
	 		<source srcset="./static/Logo-2Org-Cows64.png">
	 		<img src="./static/Logo-2Org-Cows.png" alt="2Org-Cows logo">
			</picture>
		</div>
		<div class="center">
			<div class="center_1">
			<article class="text">
				You can find further information on the project on this 
				<a href="http://coreorganicplus.org/research-projects/2-org-cows/">site</a> or 
				in this <a href="./static/Faerdig_2-Org-Cows.pdf">sheet</a>. The scientific paper, 
				regarding the database, can be found 
				<a href="http://orgprints.org/view/projects/2orgcows.html">here</a>.
			</article>
			</div>
			<div class="center_2">
				<div class="login">
				<form action="./scripts/login_script.php" method="POST">
					<table style="font-weight:bold; font-size:2.5vh; line-height:3.5vh;">
					<tr><td>Username</td><td><input type="text" name="username" required autofocus /></td></tr>
					<tr><td>Password</td><td><input type="password" name="password" required /></td></tr>
					<?php
					$_SESSION["token"] = bin2hex(random_bytes(32));
					?>
					<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>" />
					<tr><td><input type="submit" name="login" value="login" formaction="./scripts/login_script.php"/></td></tr>
					</table>
				</form>
				</div>
			<div class="notifications">
				<div class="notice1">
				<?php
					$echo = $_GET;
					echo implode(" ",$echo);
				?>
				</div>
				<div class="cookies">
				<?php
				echo $cookies_state;
				?>
				</div>
			</div>
			</div>
			</div>
		<div class="footer">
				This page was developed for the 2-Org-Cows project and underlies the BSD-license
		</div>
	</div>
</div>
</body>
</html>
