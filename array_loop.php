<?php
include_once"./scripts/agri_star_001_connect.php";
$int1 = rand(0, 99999);
$sql1 = "SELECT `test1`,`test2` FROM test";
$stmt = $test->query($sql1);
while($stmt_array = $stmt->fetch_assoc()){
		$id1 = intval($stmt_array["test1"]);
		$sql1 = "INSERT INTO test (`test1`, `test2`) VALUES ('$int1', '$id1')";
		$test->query($sql1);
		$sql2 = "INSERT INTO test (`test1`, `test2`) VALUES ('$id1', '$int1')";
		$test->query($sql2);
		global $error1;
		$error1 = $test->error;
			/*$sql3 = "INSERT INTO test (`test1`, `test2`) VALUES ('$id1', '$int1')";
			$test->query($sql3);
			global $error2;
			$error2 = $test->error;*/
}
echo $error1;
//echo $error2;
?>