<?php
error_reporting(E_ALL);
session_name("2Org-Cows");
session_start(); 
$calc = hash_hmac('sha256', 'create_group', $_SESSION["group_token"]);
/* The security hash is calculated again in this script to check, whether the data provided by the client 
match the outward criteria. Therefore, the same random number is used to generate a SHA256-hash, as in the 
client script. As both operations must deliver an equal result, csrf can be detected.
*/
if(hash_equals($calc, $_POST["group_token"])) {
unset($_SESSION["group_token"]);
unset($_SESSION["user_token"]);
unset($_SESSION["delete_token"]);
unset($_SESSION["grant_token"]);
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
unset($_SESSION["token"]);
if(!empty($_POST["new_institution"]) &&
	!empty($_POST["department"]) &&
	!empty($_POST["working_group_long"]) &&
	!empty($_POST["working_group_short"]) &&
	!empty($_POST["street"]) &&
	!empty($_POST["post-code"]) &&
	!empty($_POST["town"]) &&
	!empty($_POST["accountable_person"]) &&
	!empty($_POST["institution_email"])) {
		$email = filter_input(INPUT_POST, 'institution_email', FILTER_SANITIZE_EMAIL);
		$email = filter_var($email, FILTER_VALIDATE_EMAIL);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$val1 = "Please provide a proper e-mail address";
			header("Location: ../admin?val1=$val1");
		}
		else {
			include_once "agri_star_001_connect.php";
			$new_institution = $agri_star_001->real_escape_string($_POST["new_institution"]);//string, ID_Group is set as auto_increment value
			$working_group_long = $agri_star_001->real_escape_string($_POST["working_group_long"]);//string
			$working_group_short = $agri_star_001->real_escape_string($_POST["working_group_short"]);//string
			$new_department = $agri_star_001->real_escape_string($_POST["department"]);//string
			$street = $agri_star_001->real_escape_string($_POST["street"]);//string
			$post_code = $agri_star_001->real_escape_string($_POST["post-code"]);//string
			$town = $agri_star_001->real_escape_string($_POST["town"]);//string
			$country = $agri_star_001->real_escape_string($_POST["country"]);//string
			$accountable_person = $agri_star_001->real_escape_string($_POST["accountable_person"]);//string
			$email = $agri_star_001->real_escape_string($_POST["institution_email"]);//string
			$phone_number = $agri_star_001->real_escape_string($_POST["phone_number"]);//string
			$date = date("U");//integer
			$sql1 ="INSERT INTO Dim_Group 
			(`date_of_adding`,
			`Group_NameShort`,
			`Group_NameLong`,
			`Group_Institution`,
			`Group_Department`,
			`Group_AddressStreet`,
			`Group_AddressPostalCode`,
			`Group_AddressTown`,
			`Group_Country`, 
			`Accountable_Person`,
			`Accountable_Person_E-Mail`,
			`Accountable_Person_Telefon`
			) VALUES 
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
			?,
			?)";
			$stmt1 = $agri_star_001->prepare($sql1);
			$stmt1->bind_param('isssssssssss',
								$date,
								$working_group_short,
								$working_group_long,
								$new_institution,
								$new_department,
								$street,
								$post_code,
								$town,
								$country,
								$accountable_person,
								$email,
								$phone_number); 
			$stmt1->execute();
			$id_group = $stmt1->insert_id;
			$error1 = $agri_star_001->error;
			if($stmt1 == false) {
				$error_string1 = "Database error: $error1";
				header("Location: ../admin?val1=$error_string1");
			} else {
			$group_sql = "SELECT `ID_Group` FROM Dim_Group";
			$groups = $agri_star_001->query($group_sql);
			while($group_array = $groups->fetch_assoc()){
				$other_group = intval($group_array["ID_Group"]);
				if($other_group === $id_group) break;
					$grants_sql1 = "INSERT INTO grants (`giving_group`,`receiving_group`) VALUES ('$id_group','$other_group')";
					$agri_star_001->query($grants_sql1);
					$grants_sql2 = "INSERT INTO grants (`giving_group`,`receiving_group`) VALUES ('$other_group','$id_group')";
					$agri_star_001->query($grants_sql2);
					global $error;
					$error = $agri_star_001->error;
				/*this part is to implement the ACL for the groups, which requires all other groups to be listed already 
			First all other groups are retrieved from the database, fetched into an array and than parsed. The 
			entries for all groups are made at the same time, to allow easier access rights management during
			database operation.*/
			}
			echo $error;
			$val2 = "Institution $new_institution successfully created";
			$agri_star_001->close();
			header("Location: ../admin?val2=$val2");
			}
			}
		} else {
		$val3 = "Please complete the information, required to create an institution";
		header("Location: ../admin?val3=$val3");
	}
} else {
	$val1 = "Session terminated due to security concerns. Please check your internet connection";
	session_destroy();
	header("Location: ..?val=$val1");
}
?>