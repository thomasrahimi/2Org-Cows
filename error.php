<?php
include_once './scripts/check-session.php';
session_name("2Org-Cows");
session_start(); 
$user_role = $_SESSION["role"];
?>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css" />
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<title>Content not found</title>
</head>
<body>
<div class="page">
<div class="text a">
	<div class="header">		
		<div class="dropdown">
		<span>Menu</span>
			<div class="dropdown-content">
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
			<p><a href="./cow">Cow</a></p>
			<p><a href="./home">Home</a></p>
			<p><a href="./user">User</a></p>
			<p><a href="./logout">Logout</a></p>
			<p><a href="./help.php">Help</a></p>
			</div>
		</div>
	</div>
	<div class="logo">
	<a href="./search.php">
		<picture>
		<source srcset="./static/Logo-2Org-Cows.png" media="(min-width: 800px)">
		<source srcset="./static/Logo-2Org-Cows64.png">
		<img src="./static/Logo-2Org-Cows.png" alt="2Org-Cows logo">
		</picture>
	</a>
	</div>
	<div class="center">
	Content not found
	</div>
	</div>
	
	<div class="footer">
		This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a>
	</div>
	</div>
</body>
</html>