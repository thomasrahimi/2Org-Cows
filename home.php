<?php
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
session_name("2Org-Cows");
session_start();
include_once "./scripts/check-session.php";
$user_role = $_SESSION["role"];
?>
<html>
  <head>
    <title>home</title>
    <link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css" />
    <link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
    <meta charset="utf-8" />
  </head>
  <body>
  	<div class="page">
	<div class="text a">
		<header class="header">
		<nav class="dropdown">
			<span>Menu</span>
				<nav class="dropdown-content">
				<?php
  					if($user_role > 2) {
  				?>
				<p><a href="./admin">Admin</a></p>
				<p><a href="./measurement">Create Measurement</a></p>
				<p><a href="./upload">Upload files</a></p>
				<?php
				}
				?>
				<p><a href="./search">Search</a></p>
				<p><a href="./cow">Cow</a></p>
				<p><a href="./user">User</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
		</nav>
  		Welcome to 2Org-Cows database interface
  		<?php
  		$echo = $_GET;
  		echo implode(" ",$echo);
  		?>
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
  				<h3>Welcome</h3>
  				Welcome to the 2-Org-Cows project site. This site has been developed with HTML5, CSS3 and PHP7 
				technologies and tested with Mozilla Firefox and Google Chrome browsers. 
				In case some things do not work on your browser, please consider using 
				<a href="https://www.mozilla.org/en-US/firefox/new/">Firefox</a> or 
				<a href="https://www.google.com/chrome/">Google Chrome</a>.<br />
				In case it really does not work or you wish to have another feature in our program, 
				feel free to contact our team:<br />
				<ul>
				<li>Boris Kulig: <a href="mailto:bkulig@uni-kassel.de">bkulig@uni-kassel.de</a>, 
				project coordinator, responsible for database design</li>
				<li>Thomas Rahimi: <a href="mailto:thomas.rahimi@openmailbox.org">
				thomas.rahimi@openmailbox.org</a>, responsible for interface development</li>
				</ul>
				This page is, up till now, work in progress, so don't be astonished, if things are still changing.
				I hope your work with this page is successful and in case there are any problems, do not hesitate
				to contact me. <br />
				Kind regards <br />
				Thomas
  				</article>
  			</div>
  			<nav class="center_2">
  				<h3>Navigation</h3>
  				<ul>
  					<li><a href="./search">Search</a></li>
  					<?php
  					if($user_role > 2) {
  					?>
  					<li><a href="./admin">Admin</a></li>
  					<li><a href="./measurement">Create Measurement</a></li>
  					<li><a href="./upload">Upload files</a></li>
  					<?php
  					}
  					?>
  					<li><a href="./cow">Cow</a></li>
  					<li><a href="./user">User</a></li>
  					<li><a href="./help">Help</a></li>
  					<?php
  					if($user_role == 4) {
  					?>
  					<li><a href="./traffic">Traffic</a></li>
  					<?php
  					}
  					?>
  				</ul>
  			</nav>
  		</div>
  	<footer class="footer">
		This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a>
  	</footer>
  	</div>
  	</div>
  </body>
</html>