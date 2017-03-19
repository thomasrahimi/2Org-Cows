<?php
session_name("2Org-Cows");
session_start(); 
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
include_once './scripts/check-session.php';
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
			<p><a href="./measurement">Create Measurement</a></p>
			<p><a href="./upload">Upload files</a></p>
			<p><a href="./cow">Cow</a></p>
			<p><a href="./user">User</a></p>
			<p><a href="./home">Home</a></p>
			<p><a href="./logout">Logout</a></p>
			<p><a href="./help.php">Help</a></p>
			</nav>
		</nav>
		Please select your categories to query the database.
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
	<div class="center_head">
	<form action="./scripts/search-script.php" method="POST">
	<h3>Select your primary criteria to query the database</h3>
	<table style="border:1px solid black; border-collapse:collapse;">
	<tr>
		<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">Show</th>
		<th style="min-width:17vw; text-align:center; border:1px solid black; border-collapse:collapse;">all</th>
		<th style="min-width:14vw; text-align:center; border:1px solid black; border-collapse:collapse;">from,</th>
		<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">where</th>
		<th style="min-width:20vw; text-align:center; border:1px solid black; border-collapse:collapse;">this condition</th>
		<th style="min-width:3.5vw; text-align:center; border:1px solid black; border-collapse:collapse;">is given</th>
		<th style="min-width:17vw; text-align:center; border:1px solid black; border-collapse:collapse;">order by</th>
		
	</tr>
	<tr>
		<td style="text-align:center; border:1px solid black; border-collapse:collapse;"><!--<select></select>--></td>
		
		<td style="text-align:center; border:1px solid black; border-collapse:collapse;"><select name="search-criteria"></select></td>
		
		<td style="text-align:center; border:1px solid black; border-collapse:collapse;"><select name="search-location"></select></td>
		
		<td style="text-align:center; border:1px solid black; border-collapse:collapse;"><!--<select></select>--></td>
		
		<td style="text-align:center; border:1px solid black; border-collapse:collapse;">
		<select name="operator">
		<?php
		$operators = [
				0 => " ",
				1 => ">",
				2 => "<",
				3 => "=",
				4 => "<=",
				5 => ">=",
		];
		foreach($operators as $key => $operator){
			?>
			<option value="<?= $key ?>"><?= $operator ?></option>
			<?php
		}
		?>
		</select>
		
		<select name="condition"></select></td>
		
		<td style="text-align:center;border:1px solid black; border-collapse:collapse;"><!--<select></select>--></td>
		
		<td style="text-align:center;border:1px solid black; border-collapse:collapse;"><select name="order"></select></td>
	</tr>
	</table>
	Select further additional criteria
	<table style="border:1px solid black; border-collapse:collapse;">
	<caption>Please provide the date in the following format: YYYY-MM-DD</caption>
	<tr>
		<th style="min-width:30vw; text-align:center; border:1px solid black; border-collapse:collapse;">time beginning</th>
		<th style="min-width:30vw; text-align:center; border:1px solid black; border-collapse:collapse;">time ending</th>
		<th style="min-width:12vw; text-align:center; border:1px solid black; border-collapse:collapse;">time zone</th>
	</tr>
	<tr>
		<td style="border:1px solid black; border-collapse:collapse;">
			<input type="date" name="date_begin" />
		</td>
		<td style="border:1px solid black; border-collapse:collapse;">
			<input type="date" name="date_end" />			
		</td>
		
		<td style="border:1px solid black; border-collapse:collapse;"><select name="timezone">
			 <?php
			 $timezones_sql = "SELECT ID_Timezone, Timezone_LongName FROM Dim_Timezone";
			 $timezones = $agri_star_001->query($timezones_sql);
			 while($possible_timezones = $timezones->fetch_assoc()) { ?>
			 	<option value="<?= $possible_timezones["ID_Timezone"] ?>"><?= $possible_timezones["Timezone_LongName"] ?></option>
			 <?php
			}
			?>
			 </select>
		</td>
	</tr>
	</table>
	Do you want to save your current search?
	<table>
	<tr>
		<td style="min-width:10vw; text-align:center;">Save current search</td>
		<td style="min-width:10vw; text-align:center;"><input type="checkbox" name="save_search"/></td>
	</tr>
	<tr>
		<td>Please set a name for your search:</td>
		<td><input type="text" name="search_name" /></td>
	</tr>
	</table>
	<?php //this part is for CSRF protection
		$_SESSION["search_token"] = uniqid();
	?>
	<input type="hidden" name="search_token" value="<?= hash_hmac('sha256', 'search', $_SESSION["search_token"]) ?>"/>
	<input type="submit" name="search" value="search" formaction="./scripts/search-script.php" style="position:absolute; bottom:2,5%; left:2.5%;"/>	
	</form>
	</div>
	<div class="center_bottom">
	Use previous searches?
	<form action="./scripts/saved-searches.php" method="POST">
	<table>
		<tr>
			<td style="min-width:10vw; text-align:center;">
			Your searches:
			</td>
			<td style="min-width:10vw; text-align:center;">
			<?php
			$user_id = $_SESSION["userid"];
			$searches_sql = "SELECT ID_Search, Search_name FROM Searches WHERE 'ID_User' = '$user_id'";
			$searches = $agri_star_001->query($searches_sql);
			if($searches == 0) {
				?> 
			<p>No searches saved</p>
			<?php
			} else {
				?>
			<select name="previous_searches">
				<?php	
				while($possible_searches = $searches->fetch_assoc()) { ?>
			<option value="<?= $possible_searches['ID_Search'] ?>"><?= $possible_searches['Search_name'] ?></option>
			<?php
				}
			}
			?>
			</select>
			</td>
		</tr>
	</table>
	<?php
	$_SESSION["recover_token"] = uniqid();
	?>
	<input type="hidden" name="recover_token" value="<?= hash_hmac('sha256', 'recover_search', $_SESSION["recover_token"]) ?>"/>
	<input type="submit" name="saved-searches" value="set search" formaction="./scripts/saved-searches.php" style="position:absolute; bottom:2,5%; left:2.5%;" />
	</form>
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