<?php
#error_reporting(E_ALL);
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start(); 
if(hash_equals($_POST["token"], $_SESSION["token"])) {
unset($_SESSION["token"]);	
if(!empty($_POST["measurement_name"]) &&
	$_POST["measurement_unit"] != " ") {
		include_once "agri_star_001_connect.php";
		$link1 = $agri_star_001->real_escape_string($_POST["description"]);
		$link2 = $agri_star_001->real_escape_string($_POST["vendor_link"]);
		if(filter_var($link1,FILTER_VALIDATE_URL) == null) {
			$var1 = "Your link for description doesn't seem to be legit";
			header("Location:../measurement?val1=$var1");
			exit();
		}
		if(filter_var($link2,FILTER_VALIDATE_URL) == null) {
			$var1 = "Your vendor link doesn't seem to be legit";
			header("Location:../measurement?val1=$var1");
			exit();
		}
		else {
			$measurement_name = $agri_star_001->real_escape_string($_POST["measurement_name"]);
			$measurement_abbr = $agri_star_001->real_escape_string($_POST["measurement_abbreviation"]);
			$measurement_unit = $_POST["measurement_unit"];
			$measurement_error = $agri_star_001->real_escape_string($_POST["measurement_error"]);
			$vendor = $agri_star_001->real_escape_string($_POST["vendor"]);
			$vendor_link = $agri_star_001->real_escape_string($_POST["vendor_link"]);
			$user_id = intval($_SESSION["userid"]);
			
			$sql1 = "SELECT `User_E-Mail`,`User_Telefon` FROM Dim_User WHERE `ID_User` = '$user_id'";
			$stmt1 = $agri_star_001->query($sql1);
			$array = $stmt1->fetch_assoc();
			$email = $array["User_E-Mail"];
			$phone = $array["User_Telefon"];
			$group = intval($_SESSION["group"]);
			$sql2 = "INSERT INTO Dim_Gage (`Gage_ShortName`, 
													`Gage_LongName`, 
													`Unit`, 
													`Measurement_Error`, 
													`Vendor`, 
													`Gage_Description_Link`,
													`Group`,
													`Accountable_Person`,
													`Accountable_Person_E-Mail`,
													`Accountable_Person_Telefon`) VALUES
													(?,
													?,
													?,
													?,
													?,
													?,
													?,
													?,
													?,
													?)";
			$stmt2 = $agri_star_001->prepare($sql2);
			$stmt2->bind_param("ssssssiiss",
									$measurement_abbr,
									$measurement_name,
									$measurement_unit,
									$measurement_error,
									$vendor,
									$vendor_link,
									$group,
									$user_id,
									$email,
									$phone);
			$stmt2->execute();
			$var2 = "Method $measurement_name successfully created";
			$agri_star_001->close();
			header("Location:../measurement?val1=$var2");
			exit();
		}
	} else {
		$var3 = "Please complete the entries";
		header("Location:../measurement?val3=$var3");
		exit();
	}
} else {
	session_destroy();
	$var4 = "Session terminated for security concerns. Please check your internet connection";
	header("Location:..?val4=$var4");
	exit();
}

		
