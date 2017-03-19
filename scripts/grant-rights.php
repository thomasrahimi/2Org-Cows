<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
session_name("2Org-Cows");
session_start();
$calc = hash_hmac('sha256', 'grant_rights', $_SESSION["grant_token"]);
if(hash_equals($calc, $_POST["grant_token"])) {
	unset($_SESSION["grant_token"]);
	unset($_SESSION["delete_token"]);
	unset($_SESSION["user_token"]);
	unset($_SESSION["group_token"]);
	if(!empty($_POST["access"])) {
		include_once 'agri_star_001_connect.php';
		$giving_group = intval($_SESSION["group"]);
		foreach($_POST["access"] as $group){
			$group = intval($group);
			$sql1 = "SELECT * FROM grants WHERE `giving_group` = '$giving_group' AND `receiving_group` = '$group'";
			$stmt1 = $agri_star_001->query($sql1);
			$num_rows = $stmt1->num_rows;
			$stmt_array = $stmt1->fetch_assoc();
			$access = intval($stmt_array["access"]);
			if($num_rows == 0) {
				$sql2 = "INSERT INTO grants (`giving_group`, `receiving_group`, `access`) VALUES ('$giving_group', '$group', 1)";
				$agri_star_001->query($sql2);
			} elseif($access != 1) {
					$sql3 = "UPDATE grants SET `access` = 1 WHERE `giving_group` = '$giving_group' AND `receiving_group` = '$group'";
					$agri_star_001->query($sql3);
			}
		}
		$var1 = "Access successfully updated";
		$agri_star_001->close();
		header("Location:../admin?val1=$var1");
	} else {
		echo "error";
	}
} else {
	$var2 = "Session terminated due to security concerns";
	session_destroy();
	header("Location:..?val2=$var2");
}
?>
