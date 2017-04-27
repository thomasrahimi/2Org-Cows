<?php
#error_reporting(E_ALL);
	session_name("2Org-Cows");
	session_start(); 
	$date = date("U");
	$_SESSION["expire"] = $date + (60*60*24);
	include_once "./scripts/check-session.php";
	include_once "./scripts/agri_star_001_connect.php";
	$user_role = $_SESSION["role"];
	$group = $_SESSION["role"];
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css"/>
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<title>Cow</title>
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
				<p><a href="./measurement">Create Measurement</a></p>
				<p><a href="./upload">Upload files</a></p>
				<?php
				}
				?>
				<p><a href="./search">Search</a></p>
				<p><a href="./user">User</a></p>
				<p><a href="./home">Home</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
			</nav>
			
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
		<div class="center_search">
			<div>
				<h3>Select a farm</h3>
				<table>
					<tr>
						<td>Please choose a farm</td>
						<td>
							<select name="farm">
								<?php
								$sql1 = "SELECT `ID_Farm`,`Farm_NameLong` FROM Dim_Farm";
								?>
							</select></td>
					</tr>
				</table>
			</div>
			<div class="center_2">
				<h3 style="text-align:left;">Select the cow:</h3>
				<table>
					<tr>
						<td style="text-align:center"><input type="image" value="submit" src="./static/Arrow-left.png" alt="Previous Cow" name="previous_cow" width="25%" /></td>
						<td style="text-align:center"><input type="text" name="cow_search" /></td>
						<td style="text-align:center"><input type="image" value="submit" src="./static/Arrow-right.png" alt="Next Cow" name="next_cow" width="25%" /></td>
					</tr>
					<tr><td></td><td style="text-align:right;"><button type="submit" value="Search Cow" name="search_cow">Search Cow</button></td></tr>
				</table>
			</div>
			</div>
		</div>
		<footer class="footer">
				This page was developed for the 2-Org-Cows project and underlies the <a href="./license.php" style="color:white;">BSD-license</a>
		</footer>
	</div>
</div>
</body>
</html>