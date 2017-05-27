<?php
require_once 'session-handler.php';
session_name("login");
session_start();
#error_reporting(E_ALL);
#ini_set('display_errors', 'On');
if(!empty($_POST["token_form"])) {
if(hash_equals($_SESSION["token_session"], $_POST["token_form"])) {
	unset($_SESSION["token_session"]);
	if (!empty($_POST["username"]) && 
            !empty($_POST["username"])) {
		include_once "auth_connect.php";		
		include_once "agri_star_001_connect.php";
		include_once "logdb_connect.php";
		
		$username = htmlspecialchars($_POST["username"]);
		$username = $auth->real_escape_string($username);
		$password = htmlspecialchars($_POST["password"]);
	
		$username_sql = "SELECT `username` FROM auth WHERE `username` = ?";
		$username_prepare = $auth->prepare($username_sql);
		$username_prepare->bind_param('s',$username);
		$username_prepare->execute();
		$username_result = $username_prepare->get_result();
	
		$num_rows = $username_result->num_rows;
		if($num_rows == null) {
			$agri_star_001->close();
			$auth->close();
			$string1 ="No user found matching your username";
			header("Location: ../login.php?val1=$string1");
			exit();
		}
		else{
		$time = date("U");
		$check_time = $time - 10*60;
		$sql1 = "SELECT * FROM Failed_Login WHERE `username` = ? AND `time` > ?";
		$stmt1 = $db->prepare($sql1);
		$stmt1->bind_param('si',$username,$check_time);
		$stmt1->execute();
		$result1 = $stmt1->get_result();
		$attempts = $result1->num_rows;
		if($attempts > 3) {
			$agri_star_001->close();
			$auth->close();
			$db->close();
			$string4 = "Your account has been blocked to login, please try it later";
			header("Location:..?val4=$string4");
			exit();
		}		
		else {
			$password_sql = "SELECT `password_hash` FROM auth WHERE username = ?";
			$password_prepare = $auth->prepare($password_sql);
			$password_prepare->bind_param('s',$username);
			$password_prepare->execute();
			$password_result = $password_prepare->get_result();
			$password_array = $password_result->fetch_assoc();
			$password_query = $password_array["password_hash"];
			$password_status = password_verify($password, $password_query);//authenticate against different database, reason: security concerns
			if($password_status == TRUE) {
				$username = $auth->real_escape_string($_POST["username"]);
				$user_id_sql =  "SELECT `ID_User` FROM auth WHERE `username` = ?";
				$user_id_query = $auth->prepare($user_id_sql);
				$user_id_query->bind_param('s',$username);
				$user_id_query->execute();
				$user_id_result = $user_id_query->get_result();
				$user_id_array = $user_id_result->fetch_assoc();
				$user_id = $user_id_array["ID_User"];
						
				$user_query="SELECT `ID_Group`, `User_Role` FROM Dim_User WHERE `ID_User` = ?";
				$user_prepare = $agri_star_001->prepare($user_query);
				$user_prepare->bind_param("i", $user_id);
				$user_prepare->execute();
				$user_result = $user_prepare->get_result();
				$user_array = $user_result->fetch_assoc();
				$group = $user_array["ID_Group"];
				$role = $user_array["User_Role"];
				
				$start_time = date("U");
				$lifetime = 60*60*24;
				$expiry = $start_time + $lifetime;
				$user_agent = $agri_star_001->real_escape_string($_SERVER["HTTP_USER_AGENT"]);
				$user_ip = $_SERVER["REMOTE_ADDR"];
				session_destroy(); //destroy the old login session
				session_set_cookie_params($lifetime, $secure = true, $httponly = true);//cookies looses validity after one day
				session_name("2Org-Cows");
				session_start(); //start the new session for database queries etc
					$_SESSION["ip"] = $user_ip;
					$_SESSION["user_agent"] = $user_agent;
					$_SESSION["group"] = $group;
					$_SESSION["role"] = $role;
					$_SESSION["user"] = $username;
					$_SESSION["userid"] = $user_id;
					$_SESSION["start"] = $start_time;
					$_SESSION["expire"] = $expiry;
					$_SESSION["id"] = session_id();
				$agri_star_001->close();
				$auth->close();
				include_once "logdb_connect.php";
				$user_ip_array = explode(".", $user_ip);
				$user_ip = "$user_ip_array[0]."."$user_ip_array[1]."."$user_ip_array[2]";
				$log_sql1 = "INSERT INTO Login_Table (`time`, `ID_User`, `user_agent`, `IP`) VALUES (?, ?, ?, ?)";
				$log_query1 = $db->prepare($log_sql1);
				$log_query1->bind_param("iiss",$start_time,$user_id,$user_agent,$user_ip);
				$log_query1->execute();
				$db->close();
				header("Location:../home");
				exit();
				}
			else {
				$agri_star_001->close();
				$auth->close();
				include_once "logdb_connect.php";
				$user_agent = $db->real_escape_string($_SERVER["HTTP_USER_AGENT"]);
				$user_ip = $_SERVER["REMOTE_ADDR"];
				$user_ip_array = explode(".", $user_ip);
				$user_ip = "$user_ip_array[0]."."$user_ip_array[1]."."$user_ip_array[2]";
				$time = date("U");
				$log_sql2 = "INSERT INTO Failed_Login (`time`, `username`, `user_agent`, `IP`) VALUES (?, ?, ?, ?)";
				$log_query2 = $db->prepare($log_sql2);
				$log_query2->bind_param('isss', $time,$username,$user_agent,$user_ip);
				$log_query2->execute();
				$error = $db->error;
				$db->close();
				$string2 = "Login credentials do not match";
				header("Location: ..?val2=$string2");
				exit();
			}
		}
		}
	}
	if(empty($_POST["username"]) || empty($_POST["password"])) {
		$string3 = "Please fill in all required fields";
		header("Location: ..?val3=$string3");
		exit();
	}
}
else {
	$string1 = "Do you have cookies enabled?";
	unset($_SESSION["token"]);
	session_destroy();
	header("Location: ..?val1=$string1");
	exit();
}
}
?>
