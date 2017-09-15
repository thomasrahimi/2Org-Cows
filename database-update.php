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
	<title>Update database</title>
</head>
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
				<p><a href="./user">User</a></p>
				<p><a href="./home">Home</a></p>
				<p><a href="./logout">Logout</a></p>
				<p><a href="./help.php">Help</a></p>
				</nav>
		</nav>
		Please select a source for data input
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
		Accepted file types are:
                    <ul>
                        <li>*.csv</li>
                        <li>*.adis</li>
                        <li>*.txt</li>
                    </ul>
                    To make Excel files appropriate for the database, please convert them to csv or txt
			<form method="POST" enctype="multipart/form-data" action="./scripts/upload.php"> 
			<table>
			<tr>
				<td style="min-width:10vw; text-align:center;">Please select a file for upload</td>
				<td>
                                    <input type="hidden" name="MAX_FILE_SIZE" value=20000000 /> <!--accepts files to up till 20 MBytes -->
                                    <input type="file" size="30" name="data_files"/>
				</td>
			</tr>
			</table>
			Choose the file type
			<table>
			<tr>
                            <td>Select measurement procedure for this data</td>
                            <td><select name="choose-measurement">
                                <?php
                                include_once './scripts/agri_star_001_connect.php';
                                $group = intval($_SESSION["group"]);
                                $sql1 = "SELECT `ID_Gage`, `Gage_LongName` FROM Dim_Gage WHERE `Group` = '$group'";
                                $stmt1 = $agri_star_001->query($sql1);
                                while ($result_array = $stmt1->fetch_assoc()) { ?>
                                    <option value="<?= $result_array["ID_Gage"] ?>"><?= $result_array["Gage_LongName"] ?></option>
                                <?php 
                                }
                                $agri_star_001->close();
                                ?>
                                </select>
                            </td>
                        </tr>
			</table>
			<?php //this part is for CSRF protection
				$_SESSION["upload_token"] = uniqid();
			?>
			<input type="hidden" name="upload_token" value="<?= hash_hmac('sha256', 'upload_file', $_SESSION["upload_token"]) ?>" />
			<input type="submit" name="upload" value="upload file" formaction="./scripts/upload.php"/>
			</form></br>
			<?php
			$echo = $_GET;
			echo implode(" ", $echo);
			}
			?>
		</div>
	</div>
	<div class="center_2">
	<?php
		if ($user_role > 1) { 
			?>
			<h3>smaXtec access</h3>
			<form method="POST" action="./scripts/smaxtec.php">
				<table>
					<tr>
						<td>E-Mail</td>
						<td><input type="email" name="smaxtec_email" required /></td>
					</tr>
					<tr>
						<td>Password</td>
						<td><input type="password" name="smaxtec_password" required /></td>
					</tr>
				</table>
				<?php 
					$_SESSION["smaxtec_token"] = uniqid();
				?>
				<input type="hidden" name="smaxtec_token" value="<?= hash_hmac("sha256", "smaxtec_connect", $_SESSION["smaxtec_token"]) ?>" />
				<input type="submit" name="smaxtec_connect" value="connect to smaXtec" formaction="./scripts/smaxtec.php" />
			</form>
	<?php
		}
	?>
	</div>
	<footer class="footer">
		This page was developed for the 2-Org-Cows project and underlies the <a href="./license" style="color:white;">BSD-license</a>
	</footer>
</div>
</div>
</html>
