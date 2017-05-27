<?php
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start();
$calc = hash_hmac('sha256', 'delete_user', $_SESSION["delete_token"]);
if(hash_equals($calc, $_POST["delete_token"])) {
unset($_SESSION["delete_token"]);
unset($_SESSION["user_token"]);
unset($_SESSION["group_token"]);
unset($_SESSION["grant_token"]);
unset($_SESSION["set_password_token"]);
	if($_SESSION["role"] > 2) {
	if(isset($_POST["confirm"]) && isset($_POST["user_delete"])) {
		include_once "auth_connect.php";		
		include_once "agri_star_001_connect.php";
		$user_id = $_POST["user_delete"];
		$update_pw = openssl_random_pseudo_bytes(12);
		$update_pw_sql = "UPDATE auth SET `password_hash` = '$update_pw' WHERE `ID_User` = '$user_id'";
		$auth->query($update_pw_sql); //replace the password hash with random bytes, to prohibit login
		
		$set_active_value = "UPDATE Dim_User SET `user_not_active` = 1 WHERE `ID_User` = '$user_id'";
		$agri_star_001->query($set_active_value); //user data remain in database, but user will not be displayed anymore
		$success = "User successfully deleted";
		$auth->close();
		$agri_star_001->close();
		header("Location: ../admin?val1=$success");
		exit();
	}
	if(!isset($_POST["confirm"]) || !isset($_POST["user_delete"])) {
		$warning = "Please select user and confirm deletion";
		header("Location: ../admin?val1=$warning");
		exit();
	}
}
else {
	$val1 = "You do not have the rights to delete a user";
	header("Location:../admin?val1=$val1");
	exit();
}
}
else {
	$val1 = "Session terminated due to security concerns. Please check your internet connection";
	session_destroy();
	header("Location: ../login.php?val1=$val1");
	exit();
}
?>
