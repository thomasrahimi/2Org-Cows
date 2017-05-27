<?php
require_once './scripts/session-handler.php';
session_name("2Org-Cows");
session_start();
include_once "./scripts/check-session.php";
include_once "./scripts/agri_star_001_connect.php";
$user_id = $_SESSION["userid"];
$user = $_SESSION["user"];
$user_role = $_SESSION["role"];
$group = $_SESSION["group"];
$sql_dim_user = "SELECT `User_FullName`, `User_Institution`, `User_Department` FROM Dim_User WHERE `ID_User` = '$user_id'";
$dim_user = $agri_star_001->query($sql_dim_user);
$dim_user_array = $dim_user->fetch_assoc();
?>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css"/>
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<title>User Properties</title>
</head>
<body>
<div class="page">
	<div class="text a">
		<header class="header">
			<nav class="dropdown">
			<span>Menu</span>
				<nav class="dropdown-content">
				<?php
  					if($user_role > 1) {
  				?>
				<p><a href="./admin">Admin</a></p>
				<p><a href="./upload">Upload files</a></p>
				<p><a href="./measurement">Create Measurement</a></p>
				<?php
				}
				?>
				<p><a href="./search">Search</a></p>
				<p><a href="./cow">Cow</a></p>
				<p><a href="./home">Home</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
			</nav>
			Hello 
			<?php
			echo $dim_user_array["User_FullName"];
			?> - Checkout your personal settings and update your password
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
				<h3>Your account status</h3>
				<table style="border:1px solid black; border-collapse:collapse;">
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Your Username</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								echo $user;
							?>
						</td>
					</tr>
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Your institution</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								echo $dim_user_array["User_Institution"];
							?>
						</td>
					</tr>
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Your Department</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
							echo $dim_user_array["User_Department"];
							?>
						</td>
					</tr>
					<tr>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Your Role</td>
						<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
							<?php
								$possible_roles = [
														"student" => 1, 
														"scientific coworker" => 2, 
														"professor" => 3,
														"admin" => 4,
														];
								$role = array_search($user_role,$possible_roles);
								echo $role;
							?>
						</td>
					</tr>
				</table>
			</div>
			<div class="center_2">
				<h3>Update Password</h3>
				<form method="POST" action="./scripts/update-password.php">
					<table>
						<tr>
							<td>Your old password</td>
							<td><input type="password" name="old_password" required /></td>
						</tr>
						<tr>
							<td>Your new password</td>
							<td><input type="password" name="new_password" required /></td>
						</tr>
						<tr>
							<td>Verify your password</td>
							<td><input type="password" name="verify_password" required /></td>
						</tr>
					</table>
					<?php
					$_SESSION["update_password_token"] = bin2hex(random_bytes(32));
					?>
					<input type="hidden" name="update_password_token" value="<?= $_SESSION["update_password_token"] = bin2hex(random_bytes(32)) ?>" />
					<input type="submit" name="submit_password" value="change password" formaction="./scripts/update-password.php" />
				</form>
				<?php
					$echo = $_GET;
					echo implode(" ", $echo);
				?>
			</div>
		</div>
		<footer class="footer">
			This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a>
		</footer>
	</div>
</div>
</body>
</html>
