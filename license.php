<?php
require_once './scripts/session-handler.php';
session_name("2Org-Cows");
session_start(); 
include_once "./scripts/check-session.php";
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
$user_role = $_SESSION["role"];
?>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css" />
	<link rel="shortcut icon" type="image" href="./static/Favicon-2Org-Cows.ico" />
	<title>license</title>
</head>
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
			<p><a href="./cow">Cow</a></p>
			<p><a href="./user">User</a></p>
			<p><a href="./home">Home</a></p>
			<p><a href="./logout">Logout</a></p>
			<p><a href="./help.php">Help</a></p>
			</nav>
		</nav>
		
		License
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
		<div class="center_head">
		Copyright (c) 2016, Universität Kassel <br>
All rights reserved.<br>

Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:<br>

1. Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.<br>

2. Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.<br>

3. Neither the name of the copyright holder nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.<br>

4. The use of this software, as a whole or in parts for military, lawful interception or surveillance means is prohibited.<br>

THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND 
FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, 
PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
		</div>
		</div>
		<footer class="footer">
			This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a>
		</footer>
	</div>
	</div>
</html>
