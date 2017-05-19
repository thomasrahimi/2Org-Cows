<?php
#ini_set('display_errors',1);
#error_reporting(E_ALL);
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
			$sql1 = "SELECT * FROM grants WHERE `giving_group` = ? AND `receiving_group` = ?";
			$stmt1 = $agri_star_001->prepare($sql1);
			$stmt1->bind_param('ii',$giving_group,$group);
			$stmt1->execute();
			$stmt1_result = $stmt1->get_result();
			$num_rows = $stmt1_result->num_rows;
			$stmt_array = $stmt1_result->fetch_assoc();
			$access = intval($stmt_array["access"]);
			if($num_rows == 0) {
				$sql2 = "INSERT INTO grants (`giving_group`, `receiving_group`, `access`) VALUES (?,?, 1)";
				$stmt2 = $agri_star_001->prepare($sql2);
				$stmt2->bind_param('ii',$giving_group,$group);
				$stmt2->execute();
			} elseif($access != 1) {
					$sql3 = "UPDATE grants SET `access` = 1 WHERE `giving_group` = ? AND `receiving_group` = ?";
					$stmt3 = $agri_star_001->prepare($sql3);
					$stmt3->bind_param('ii',$giving_group,$group);
					$stmt3->execute();
			}
		}
                $sql2 = "SELECT * FROM grants WHERE `giving_group` = ? AND `access` = 1";
                $stmt2 = $agri_star_001->prepare($sql2);
                $stmt2->bind_param('i', $giving_group);
                $stmt2->execute();
                $stmt2_result = $stmt2->get_result();
                while ($stmt2_array = $stmt2_result->fetch_assoc()) {
                    foreach ($_POST["access"] as $group){
                        $receiving_group = $stmt2_array["receiving_group"];
                        $check_array = in_array($receiving_group,$_POST["access"]);
                        if ($check_array === false) {
                            $sql3 = "UPDATE grants SET `access`= 0 WHERE `giving_group` = ? AND `receiving_group` = ?";
                            $stmt3 = $agri_star_001->prepare($sql3);
                            $stmt3->bind_param('ii', $giving_group, $receiving_group);
                            $stmt3->execute();
                        }
                        
                        
                    }
                    
                }
                
		$var1 = "Access successfully updated";
		$agri_star_001->close();
		header("Location:../admin?val1=$var1");
		exit();
	} else {
		echo "error";
	}
} else {
	$var2 = "Session terminated due to security concerns";
	session_destroy();
	header("Location:..?val2=$var2");
	exit();
}
?>
