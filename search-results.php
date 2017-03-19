<?php
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
session_name("2Org-Cows");
session_start(); 
include_once './static/check-session.php';
include_once "./scripts/agri_star_001_connect.php";
?>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css" />
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<title>search</title>
</head>
<body>
<div class="page">
<div class="text a">
	<header class="header">		
		<nav class="dropdown">
		<span>Menu</span>
			<nav class="dropdown-content">
			<p><a href="./admin">Admin</a></p>
			<p><a href="./upload">Upload files</a></p>
			<p><a href="./cow">Cow</a></p>
			<p><a href="./user">User</a></p>
			<p><a href="./home">Home</a></p>
			<p><a href="./logout">Logout</a></p>
			<p><a href="./help.php">Help</a></p>
			</nav>
		</nav>
		
		<?php
		$echo = $_GET;
		echo implode(" ",$echo);
		?>
	</header>
	<div class="logo">
	<a href="./search.php">
	<picture>
	<source srcset="./static/Logo-2Org-Cows.png" media="(min-width: 800px)">
	<source srcset="./static/Logo-2Org-Cows64.png">
	<img src="./static/Logo-2Org-Cows.png" alt="2Org-Cows logo">
	</picture>
	</a>
	</div>
	<div class="center_search">
	<div class="center_head">
	<div class="search">
	
	</div>
	</div>
	</div>
	<footer class="footer">
				This page was developed for the 2-Org-Cows project and underlies the <a href="./license.php" style="color:white;">BSD-license</a>
	</footer>
	</body>
	</html>
	<?php
	$agri_star_001->close();
	?>