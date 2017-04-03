<?php
error_reporting(E_ALL);
	$date = date("U");
	$_SESSION["expire"] = $date + (60*60*24);
	include_once "./scripts/check-session_restricted.php";
	include_once "./scripts/agri_star_001_connect.php";
	session_name("2Org-Cows");
	session_start(); 
	$user_role = $_SESSION["role"]; //user_role important for the content displayed to the specific user
	$group = $_SESSION["group"];
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css"/>
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<!--<script type="text/javascript" src="./static/check-password.js"></script>
	<script type="text/javascript" src="./static/institution-choice.js"></script>-->
	<title>Admin</title>
</head>
<body>
	<div class="page">
	<div class="text a">
		<header class="header">
		<nav class="dropdown">
			<span>Menu</span>
				<nav class="dropdown-content">
				<p><a href="./search">Search</a></p>
				<p><a href="./measurement">Create Measurement</a></p>
				<p><a href="./upload">Upload files</a></p>
				<p><a href="./user">User</a></p>
				<p><a href="./cow">Cow</a></p>
				<p><a href="./home">Home</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
			</nav>
		If you want to create a new user, fill in the required data.     
		<?php
				$echo = $_GET;
				echo implode(" ",$echo);
			?>
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
			<h3>Create new user</h3>
				<?php
					include_once("./include/create-user-form.php");
				?>	
			</div>
			<div class="center_2">
			<?php
			if($user_role > 2) {
			?>
			<h3>Create new institution</h3>
			<?php
				include_once("./include/create-institution-form.php");
			}
			?>
			</div>
			<div class="center_3">
			<?php
			$user_id = intval($_SESSION["userid"]);
			if($user_role > 2) {
				?>
			<h3>Delete users</h3>
			<form action="scripts/delete_user_script.php" method="POST">
			<table>
			<tr><td>Select user to delete</td><td><select name="user_delete">
			<?php
				$sql3 = "SELECT `ID_User`, `User_FullName` FROM Dim_User WHERE (`ID_Group` = '$group') AND (`ID_User` <> '$user_id') AND (`user_not_active` IS NULL)";
				$user = $agri_star_001->query($sql3);
				while($user_array = $user->fetch_assoc()) {
			?>
			<option value="<?= $user_array["ID_User"] ?>"><?= $user_array["User_FullName"] ?></option>
			<?php
				}
			?>
			</select>
			</td></tr>
			<tr><td><input type="checkbox" name="confirm"></td>
			<td>Do you really want to delete that user?</td></tr>
			</table>
			<?php
			 	$_SESSION["delete_token"] = uniqid(); //this part is for CSRF protection
			?>
			<input type="hidden" name="delete_token" value="<?= hash_hmac('sha256', 'delete_user', $_SESSION["delete_token"]) ?>"/>
			<input type="submit" name="delete_user" value="delete user" formaction="./scripts/delete_user_script.php" />
			</form>
			<?php
			}
			?>
			</div>
			<div class="center_4">
			<!--First user:
			<a href="./scripts/first-user.php">First User</a>-->
			<?php
			if($user_role > 2) {
			?>
			<h3>Grant rights to other partners</h3>
			<form action="./scripts/grant-rights.php" method="POST">
			<table style="border:1px solid black; border-collapse:collapse;">
			<tr>
				<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Institution</th>
				<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Department</th>
				<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">access to your data?</th>
			</tr>
			<?php
				$sql4 = "SELECT `ID_Group`, `Group_Institution`, `Group_Department` FROM Dim_Group WHERE `ID_Group` <> '$group'";
				$groups = $agri_star_001->query($sql4);
				while($group_array = $groups->fetch_assoc()) {
					$institution = $group_array['Group_Institution'];
					$department = $group_array['Group_Department'];
					$id_group = $group_array["ID_Group"];
					$sql5 = "SELECT `access` FROM grants WHERE `giving_group` = '$group' AND `receiving_group` = '$id_group'";
					$granted = $agri_star_001->query($sql5);
					$grant_array = $granted->fetch_assoc();
					$grant = $grant_array["access"];
			?>
				<tr>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $institution ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $department ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
					<?php
					if($grant == 1) {
					?>
						<input type="checkbox" name="access[]" checked value="<?= $id_group ?>"/>
					<?php
					} else {
					?>
						<input type="checkbox" name="access[]" value="<?= $id_group ?>"/>
					<?php
					}
					?>
					</td>
				</tr>
			<?php
				}
			?>
			</table>
			<?php
				$_SESSION["grant_token"] = uniqid();
			?>
			<input type="hidden" name="grant_token" value="<?= hash_hmac('sha256', 'grant_rights', $_SESSION["grant_token"]) ?>" />
			<input type="submit" name="grant_rights" value="grant rights" formaction="./scripts/grant-rights.php" />
			</form>
			<?php
			}
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
<?php
	$agri_star_001->close();
?>