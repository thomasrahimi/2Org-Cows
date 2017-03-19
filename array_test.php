<?php
error_reporting(+1);
session_name("2Org-Cows");
session_start();
?>
Both array:<br>
<?php
include_once"./scripts/agri_star_001_connect.php";
$country_string1 = "SELECT Country_NameLong, ID_Country FROM Dim_Country";
$country1 = $agri_star_001->query($country_string1);
while($country_array1 = $country1->fetch_array()) {
	print_r($country_array1);
}
?><br>
associative array:<br>
<?php
$country_string2 = "SELECT ID_Country, Country_NameLong FROM Dim_Country";
$country2 = $agri_star_001->query($country_string2);
while($country_array2 = $country2->fetch_assoc()) {
	print_r($country_array2);
}
?>
<br>
Separated country:<br>
<?php
$country_string3 = "SELECT ID_Country, Country_NameLong FROM Dim_Country";
$country3 = $agri_star_001->query($country_string3);
while($country_array3 = $country3->fetch_assoc()) {
	$country_name = $country_array3["Country_NameLong"];
	print_r($country_name);
}
?>
Random number
<?php
$var1 = random_int(1,99999999);
print_r($var1);
?>
<br>
<?php
$session = $_SESSION;
$user = $_SESSION["user"];
$user_id = $_SESSION["userid"];
$ip = $_SESSION["ip"];
$user_agent = $_SESSION["user_agent"];
$group = $_SESSION["group"];
$role = $_SESSION["role"];
$start = $_SESSION["start"];
?>
Session = <?php
print_r($session);
?>
<br/>
User = <?php
print_r($user);
?>
<br>
Group = 
<?php
print_r($group);
?>
<br>
User-ID = 
<?php
print_r($user_id);
?>
<br>
IP = <?php
print_r($ip);
?>
<br>
User-Agent = <?php
print_r($user_agent);
?>
<br>
Role = <?php
print_r($role);
?>
<br>
Start = <?php
print_r($start);
?>
<br />
Numeric Array: <br />
<?php //https://stackoverflow.com/questions/6234313/create-a-variable-for-while-loop-results
$group_array = " ";
$group_sql = "SELECT `ID_Group` FROM Dim_Group";
$groups = $agri_star_001->query($group_sql);
while($group_array = $groups->fetch_row()){
	print_r($group_array);
}
?>
<br />
Associative Array: <br />
<?php
$group_sql = "SELECT `ID_Group` FROM Dim_Group";
$groups = $agri_star_001->query($group_sql);
while($group_array2 = $groups->fetch_assoc()) {
	print_r($group_array2);
}
?>