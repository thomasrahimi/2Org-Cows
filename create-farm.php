<?php
require_once './scripts/session-handler.php';
session_name("2Org-Cows");
session_start();
include_once './scripts/check-session_restricted.php';
?>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css" />
	<link rel="shortcut icon" type="image" href="./static/Favicon-2Org-Cows.ico" />
    <title>Create farm</title>
</head>
<body>
<div class="page">
<div class="text a">
	<header class="header">
		<nav class="dropdown">
			<span>Menu</span>
				<nav class="dropdown-content">
				<p><a href="./search">Search</a></p>
				<p><a href="./admin">Admin</a></p>
				<p><a href="./measurement">Create Measurement</a></p>
				<p><a href="./cow">Cow</a></p>
                <p><a href="./upload">Upload files</a></p>
				<p><a href="./user">User</a></p>
				<p><a href="./home">Home</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
		</nav>
        Please create a new farm
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
		<?php
		$user_role = $_SESSION["role"];
		if ($user_role > 1) { 
                ?>
        <h3>Please enter the data required to create a new farm</h3>
        <form method="POST" action="./scripts/create-farm_script.php">
            <table>
                <tr>

                </tr>
            
            </table>
        </form>
    </div>
    <footer class="footer">This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a></footer>
</div>
</div>
</body>
</html>