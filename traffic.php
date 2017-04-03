<?php
session_name("2Org-Cows");
session_start();
include_once "./scripts/check-session_restricted.php";
if($_SESSION["role"] != 4) {
	$var1 = "You are not allowed to visit this page";
	header("Location:../home?val1=$var1");
}
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Check Website traffic</title>
		<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css" />
    	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	</head>
	<body>
	<div class="page">
	<div class="text a">
		<header class="header">
			<nav class="dropdown">
			<span>Menu</span>
				<nav class="dropdown-content">
				<p><a href="./home">Home</a></p>
				<p><a href="./admin">Admin</a></p>
				<p><a href="./search">Search</a></p>
				<p><a href="./measurement">Create Measurement</a></p>
				<p><a href="./upload">Upload files</a></p>
				<p><a href="./cow">Cow</a></p>
				<p><a href="./user">User</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
			</nav>
			Check on the website traffic of 2Org-Cows
		</header>
		<div class="logo">
		<a href="./home">
			<picture>
			 <source srcset="./static/Logo-2Org-Cows.png" media="(min-width: 800px)">
	 		 <source srcset="./static/Logo-2Org-Cows64.png">
	 		 <img src="./static/Logo-2Org-Cows.png" alt="2Org-Cows logo">
			</picture>
		</a>
		</div>
		<div class="center">
			<div class="center_1">
				<h3>Traffic on Login page</h3>
				<table style="border:1px solid black; border-collapse:collapse;">
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							Amount of Accesses on the page within the last week
						</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								include_once "./scripts/logdb_connect.php";
								include_once "./scripts/agri_star_001_connect.php";
								$time = 60*60*24*7;
								$week = $date - $time;
								$sql1 = "SELECT `time`, `user_ip` FROM Log_Table WHERE `time` > '$week'";
								$result = $db->query($sql1);
								$accesses = $result->num_rows;
								echo $accesses;
							?>
						</td>
					</tr>
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							IP addresses accessing page
						</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								while($result_array = $result->fetch_assoc()) {
									$ip_address = $result_array["user_ip"];
									$unix_time1 = $result_array["time"];
									$iso_time1 = gmdate('Y-m-d\ H:i:s', $unix_time1);
									echo nl2br("$ip_address → $iso_time1 \n");
								}
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="center_2">
				<h3>Logins</h3>
				<table style="border:1px solid black; border-collapse:collapse;">
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							Amount of Logins within the last week
						</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								$sql2 = "SELECT `time`, `ID_User`, `IP` FROM Login_Table WHERE `time` > '$week'";
								$result2 = $db->query($sql2);
								$logins = $result2->num_rows;
								echo $logins;
								$error = $db->error;
							?>
						</td>
					</tr>
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							IP addresses accessing page
						</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								while($result_array2 = $result2->fetch_assoc()){
									$ip_address2 = $result_array2["IP"];
									$id_user = $result_array2["ID_User"];
									$sql3 = "SELECT `User_FullName` FROM Dim_User WHERE `ID_User` = '$id_user'";
									$result3 = $agri_star_001->query($sql3);
									$result_array3 = $result3->fetch_assoc();
									$username = $result_array3["User_FullName"];
									$unix_time2 = $result_array2["time"];
									$iso_time2 = gmdate('Y-m-d\ H:i:s', $unix_time2);
									echo nl2br("$ip_address2 → $username ($iso_time2) \n");
								}
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="center_4">
				<h3>Failed logins</h3>
				<table style="border:1px solid black; border-collapse:collapse;">
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							Amount of failed logins within the last week
						</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								$sql4 = "SELECT * FROM Failed_Login WHERE `time` > '$week'";
								$failed_login = $db->query($sql4);
								$fails = $failed_login->num_rows;
								echo $fails;
							?>
						</td>
					</tr>
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							Data on failed logins
						</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								while($failed_login_array = $failed_login->fetch_assoc()) {
									$ip_address3 = $failed_login_array["IP"];
									$login_username = $failed_login_array["username"];
									$unix_time3 = $failed_login_array["time"];
									$iso_time3 = gmdate('Y-m-d\ H:i:s', $unix_time3);
									echo nl2br("$ip_address3 → $login_username ($iso_time3) \n");
								}
							?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<footer class="footer">This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a></footer>
	</div>
	</div>
	</body>
</html>