<?php
session_name("2Org-Cows");
session_start();
if(!empty($_POST["update_password_token"])) {
	if(hash_equals($_SESSION["update_password_token"], $_POST["update_password_token"])) {
		unset($_SESSION["update_password_token"]);
		if(!empty($_POST["old_password"]) && 
			!empty($_POST["new_password"]) && 
			!empty($_POST["verify_password"])) {
				include_once "auth_connect.php";
				$id_user = intval($_SESSION["userid"]);
				$old_password = $_POST["old_password"];
				$new_password = $_POST["new_password"];
				$verify_password = $_POST["verify_password"];
				$sql1 = "SELECT `password_hash` FROM auth WHERE `ID_User`= '$id_user'";
				$result1 = $auth->query($sql1);
				$result_array = $result1->fetch_assoc();
				$old_password_hash = $result_array["password_hash"];
				$match_old_password = password_verify($old_password, $old_password_hash);
				if($match_old_password == true) {
					if(strcmp($new_password, $verify_password) == 0) {
						$password = password_hash($new_password, PASSWORD_DEFAULT, ['cost' => 12]);
						$sql2 = "UPDATE auth SET `password_hash` = '$password' WHERE `ID_User` = ?";
						$update_password = $auth->prepare($sql2);
						$update_password->bind_param('i', $id_user);
						$update_password->execute();
						$success = "Password successfully updated";
						$auth->close();
						header("Location:../user?val1=$success");
						exit();
					} else {
							$auth->close();
							$string1 = "Your new password does not match the controll";
							header("Location:../user?val1=$string1");
							exit();
							}
				} else {
					$auth->close();
					$string2 = "Your old password does not match";
					header("Location:../user?val1=$string2");
					exit();
				}
			} else {
				$string3 = "Please fill in all required fields";
				header("Location:../user?val1=$string3");
				exit();
			}
	} else {
		$string4 = "Session terminated due to security concerns. Please check your internet connection";
		session_destroy();
		header("Location:..?val1=$string4");
		exit();
	}
}
?>
