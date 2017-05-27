<?php
#ini_set('display_errors',1);
#error_reporting(E_ALL);
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start(); 
$calc = hash_hmac('sha256', 'user_form', $_SESSION["user_token"]);
if(hash_equals($calc, $_POST["user_token"])) {
	unset($_SESSION["user_token"]);
	unset($_SESSION["group_token"]);
	unset($_SESSION["delete_token"]);
	unset($_SESSION["grant_token"]);
	unset($_SESSION["set_password_token"]);
	$date = date("U");
	$_SESSION["expire"] = $date + (60*60*24);
	if(!empty($_POST["fullname"]) && 
		!empty($_POST["username"]) && 
		!empty($_POST["password"]) && 
		!empty($_POST["user_email"]) &&
		!empty($_POST["phone_number"])) {			
			include_once "agri_star_001_connect.php";
			include_once "auth_connect.php";
			$email = filter_input(INPUT_POST, 'user_email', FILTER_SANITIZE_EMAIL);
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			$password_check1 = htmlspecialchars($_POST["password"]);
			$password_check2 = htmlspecialchars($_POST["repeat_password"]);
			$fullname = $agri_star_001->real_escape_string($_POST["fullname"]);
			
			$username = $agri_star_001->real_escape_string($_POST["username"]);
			$username = strtolower($username);
			$check_username_sql ="SELECT `username` FROM auth WHERE `username` = ?";//check if username exists already
			$check_username = $auth->prepare($check_username_sql);
			$check_username->bind_param('s',$username);
			$check_username->execute();
			$username_result = $check_username->get_result();
			$num_rows_username = $username_result->num_rows;
			
			$user_role = intval($agri_star_001->real_escape_string($_POST["user_role"]));
			
			$group_id = intval($_POST["group"]);
			$institution_sql = "SELECT `Group_Institution`, `Group_Department`,`Group_Country` FROM Dim_Group WHERE `ID_Group` = ?";
			$institution = $agri_star_001->prepare($institution_sql);
			$institution->bind_param('i',$group_id);
			$institution->execute();
			$institution_result = $institution->get_result();
			$num_rows_group = $institution_result->num_rows; //checks, if the institution exists
			
			$institution_array = $institution_result->fetch_assoc();
			$institution_name = $institution_array["Group_Institution"];
			$department = $institution_array["Group_Department"];
			$country_value = $institution_array["Group_Country"];
						
			$country_sql = "SELECT `ID_Country` FROM Dim_Country WHERE `Country_NameLong` = '$country_value'";
			$country_result = $agri_star_001->query($country_sql);
			$country_array = $country_result->fetch_assoc();
			$country = intval($country_array["ID_Country"]);
			
			$phone_number = $agri_star_001->real_escape_string($_POST["phone_number"]); //string
			$date = date("U"); //integer
			$creator_id = intval($_SESSION["userid"]); //integer, ID_User is set as auto_increment value within mysql database!!
			$controll_user_role_array = range(1,4,1);
			
			if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$agri_star_001->close();
				$auth->close();
				$string2 = "Please provide a proper e-mail address";
				header("Location: ../admin?val2=$string2");
				exit();
			}		
			if(strcmp($password_check1, $password_check2) !== 0) {
				$agri_star_001->close();
				$auth->close();
				$string3 = "Passwords do not match";
				header("Location: ../admin?val7=$string3");
				exit();
			}				
			if($num_rows_username != null) {
				$agri_star_001->close();
				$auth->close();
				$string4 = "username not available";
				header("Location: ../admin?val4=$string4");
				exit();
			}
			if(in_array($user_role, $controll_user_role_array) == FALSE) {  //checks, if the user role is in the allowed area
				$agri_star_001->close();
				$auth->close();
				$string5 = "Error choosing user role";
				header("Location: ../admin?val5=$var5");
				exit();
			}
			if($user_role == 0) { 
				$agri_star_001->close();
				$auth->close();
				$string6 = "please select a role for the user";
				header("Location: ../admin?val6=$string6");
				exit();
			}
			if($num_rows_group == 0) {
				$agri_star_001->close();
				$auth->close();
				$string7 = "The requested group does not exist";
				header("Location: ../admin?val7=$string7");
				exit();
				}
			if($_SESSION["role"] == 2 && $user_role > 2) {
				$agri_star_001->close();
				$auth->close();
				$string8 = "You are not allowed to create users with higher permissions";
				header("Location: ../admin?val8=$string8");
				exit();
			}
			if($_SESSION["role"] == 2 && $group_id != $_SESSION["group"]) {
				$agri_star_001->close();
				$auth->close();
				$string9 = "You are not allowed to modify the group";
				header("Location: ../admin?val9=$string9");
				exit();
			}
			else {
			$password = htmlspecialchars($_POST["password"]);
			$password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12 ]); //hashing using bcrypt
			$sql1 = "INSERT INTO Dim_User 
			(`ID_Group`,
			`ID_Country`, 
			`User_FullName`,
			`User_Institution`,
			`User_Department`, 
			`User_E-Mail`, 
			`User_Telefon`,
			`User_Mobile`,
			`User_Role`, 
			`User_Creator`, 
			`date_of_adding`) VALUES 
			(?,
			?,
			?,
			?,
			?,
			?,
			?,
			?,
			?,
			?,
			?)";// no username in Dim_User table, also for security reasons. Just use user_id as key for user
			$dim_user = $agri_star_001->prepare($sql1);
			$dim_user->bind_param('iissssssiii',
										$group_id,
										$country,
										$fullname,
										$institution_name,
										$department,
										$email,
										$phone_number,
										$mobile_number,
										$user_role,
										$creator_id,
										$date);
			$dim_user->execute();
			$errors1 = $agri_star_001->error;
			if($dim_user == false) {
				$error_string1 = "Database error: $errors1";
				header("Location: ../admin?val1=$error_string1");
				exit();
			} else {
			$id_user = $dim_user->insert_id; //retrieves the auto_increment value of the Dim_User transaction
			$sql2 = "INSERT INTO auth 
			(`ID_User`,
			`username`, 
			`password_hash`) 
			VALUES 
			(?, ?, ?)";
			$auth_table = $auth->prepare($sql2);
			$auth_table->bind_param('iss',
											$id_user,
											$username,
											$password_hash);
			$auth_table->execute();
			$errors2 = $auth->error;
			if($auth_table == false) {
				$error_string2 = "Database error 2: $errors2";
				header("Location: ../admin?val1=$error_string2");
				exit();
			} else {
			$string1 = "user $fullname successfully created";
			$agri_star_001->close();
			$auth->close();
			header("Location: ../admin?val1=$string1");
			exit();
			}
			}
		}
		} else {
			$string6 = "Please complete your information";
			header("Location: ../admin?val6=$string6");
			exit();
		}

} else {
	$val1 = "Session terminated due to security concerns. Please check your internet connection";
	session_destroy();
	header("Location: ..?val1=$val1");
	exit();
}
?>
