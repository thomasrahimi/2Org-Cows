<?php
error_reporting(E_ALL);
	session_name("2Org-Cows");
	session_start(); 
	$date = date("U");
	$_SESSION["expire"] = $date + (60*60*24);
	include_once "./scripts/check-session_restricted.php";
	include_once "./scripts/agri_star_001_connect.php";
?>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" type="text/css" href="./static/2Org-Cows.css"/>
	<link rel="shortcut icon" href="./static/Favicon-2Org-Cows.ico" type="image"/>
	<title>create measurement</title>
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
				<p><a href="./upload">Upload files</a></p>
				<p><a href="./cow">Cow</a></p>
				<p><a href="./user">User</a></p>
				<p><a href="./home">Home</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
			</nav>
			Please provide the information required to create new measurement methods
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
			<h3>Create new measurement method</h3>
				<form method="POST" action="./scripts/measurement_script.php">
					<table>
						<tr>
							<td>Measurement name</td>
							<td><input type="text" name="measurement_name" required autofocus /></td>
						</tr>
						<tr>
							<td>Abbreviation for measurement</td>
							<td><input type="text" name="measurement_abbreviation" required /></td>
						</tr>
						<tr>
							<td>Measurement Unit</td>
							<td>
								<select name="measurement_unit">
								<?php
								$measurement_units = [
															" " => " ",
															"kg" => "kg",
															"m" => "m",
															"l" => "l",
															"m³" => "m³"];
								foreach($measurement_units as $key => $unit){
								?>
								<option value="<?= $key ?>"><?= $unit ?></option>
								<?php
								}
								?>
								</select>
							</td>
						</tr>
						<tr>
							<td>Measurement Error</td>
							<td><input type="text" name="measurement_error" required /></td>
						</tr>
						<tr>
							<td>Link to description</td>
							<td><input type="text" name="description" placeholder="http://" required /></td>
						</tr>
						<tr>
							<td>Vendor</td>
							<td><input type="text" name="vendor" required /></td>
						</tr>
						<tr>
							<td>Link to Vendor</td>
							<td><input type="text" name="vendor_link" placeholder="http://" required /></td>
						</tr>		
					</table>
						<?php
			 				$_SESSION["token"] = bin2hex(random_bytes(32)); //this part is for CSRF protection
						?>
							<input type="hidden" name="token" value="<?= $_SESSION["token"] ?>" />
							<input type="submit" value="create method" formaction="./scripts/measurement_script.php" />

				</form>
				<br>
				<?php
					$echo = $_GET;
					echo implode(" ",$echo);
				?>
			</div>
			<div class="center_2">
			<h3>Measurement methods, created by your group</h3>
				<table style="border:1px solid black; border-collapse:collapse;">
				<tr>
					<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Measurement Method</th>
					<th style="min-width:2vw; text-align:center; border:1px solid black; border-collapse:collapse;">Abbr.</th>
					<th style="min-width:2vw; text-align:center; border:1px solid black; border-collapse:collapse;">Unit</th>
					<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Measurement Error</th>
					<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Vendor</th>
					<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Description Link</th>
				</tr>
				<?php
				$group = intval($_SESSION["group"]);
				$sql = "SELECT `Gage_LongName`,`Gage_ShortName`,`Unit`,`Measurement_Error`, `Vendor`, `Gage_Description_Link` FROM Dim_Gage WHERE `Group` = '$group'";
				$measurements = $agri_star_001->query($sql);
				while($measurement_array = $measurements->fetch_assoc()) {
				?>
				<tr>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $measurement_array['Gage_LongName'] ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $measurement_array['Gage_ShortName'] ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $measurement_array['Unit'] ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $measurement_array['Measurement_Error'] ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;"><?= $measurement_array['Vendor'] ?></td>
					<td style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">
						<a target="_blank" href="<?= $measurement_array['Gage_Description_Link'] ?>" ><?= $measurement_array['Gage_Description_Link'] ?></a>
					</td>
				</tr>
				<?php
					}
				?>
				</table>
			</div>
		</div>
		<footer class="footer">
				This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a>
		</footer>
	</div>
</div>
</body>
</html>