<?php
require_once 'session-handler.php';
session_name("2Org-Cows");
session_start(); 
$calc = hash_hmac('sha256', 'search', $_SESSION["search_token"]);
if(hash_equals($calc, $_POST["search_token"])) {
unset($_SESSION["search_token"]);
$date = date("U");
$_SESSION["expire"] = $date + (60*60*24);
if(isset($_POST["search-criteria"]) && isset($_POST["operator"]) && isset($_POST["condition"])) {
	include_once "agri_star_001_connect.php";
	$search_criteria = $_POST["search-criteria"];//int
	$search_location = $_POST["search-location"];//int
	$operator = $_POST["operator"];//int
	$condition = $_POST["condition"];//int
	$order = $_POST["order"];//int
	$day_begin = $_POST["day_begin"];//int
	$month_begin = $_POST["month_begin"];//int
	$year_begin = $_POST["year_begin"];//int
	$day_end = $_POST["day_end"];//int
	$month_end = $_POST["month_end"];
	$year_end = $_POST["year_end"];
	$timezone = $_POST["timezone"];
	if($day_begin != 0 && 
	 $month_begin != 0 && 
	 $year_begin != 0 || 
	 $day_end != 0 && 
	 $month_end != 0 &&
	 $year_end != 0
	) {
		$year_begin4 = $year_begin / 4;
		$year_begin100 = $year_begin / 100;
		$year_end4 = $year_end /4;
		$year_end100 = $year_end /100;
		if($day_begin >= 29 && 
		$month_begin == 2 && 
		is_int($year_begin4)== false &&
		is_int($year_begin100) == true || 
		$day_end >= 29 &&
		$month_end == 2 &&
		is_int($year_end4) == false &&
		is_int($year_end100) == true
		) {
			$switching_year = "You forgot about the switching year";
			header("Location: ../search.php?val1=$switching_year");
		}
	if(isset($_POST["save-search"])) {
	$search_name = mysqli_real_escape_string($_POST["search_name"]);
	$id_user = $_SESSION["userid"];
	$search_id = random_int(1,99999999999);
	$save_query_sql = "INSERT INTO Search (
	ID_User,
	ID_Search, 
	Search_name,
	Search_Criteria,
	Search_Location,
	Operator,
	Search_Condition,
	Search_Order,
	Date_Begin,
	Date_End,
	Timezone) VALUES (
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
	?)
	";
	$stmt = $agri_star_001->prepare($save_query_sql);
	$stmt->bind_param('iiiiiiiiii',
							$id_user,
							$search_id,
							$search_name,
							$search_criteria,
							$search_location,
							$operator,
							$condition,
							$order,
							$date_begin,
							$date_end,
							$timezone);
	$stmt->execute();
	}
	$create_string = "$search_criteria && $search_location && $operator && $condition && $order && $date_begin && $date_end && $timezone"; //please find out how to continue the current statement
	header("Location: ../results.php?val1=$create_string");
	exit();
}
}
else {
	$var2 = "Please complete your search";
	header("Location: ../search?val2=$var2");
	exit();
}
$agri_star_001->close();
}
else {
$val1 = "Session terminated due to security concerns. Please check your internet connection";
session_destroy();
	header("Location: ../login.php?val1=$val1");
	exit();
}
?>
