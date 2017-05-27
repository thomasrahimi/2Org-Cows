<?php
if($user_role == 3) {
$possible_roles = [
				0 => "",
				1 => "student", 
				2 => "scientific coworker", 
				3 => "professor",
				];
foreach ($possible_roles  as $value => $role) { ?>
<option value="<?= $value ?>"><?= $role ?></option>
<?php
}
}
elseif($user_role == 2) {
$possible_roles = [
				0 => "",
				1 => "student", 
				2 => "scientific coworker",
				];
			foreach ($possible_roles as $value => $role) { ?>
<option value="<?= $value ?>"><?= $role ?></option>
<?php
}
}
elseif($user_role == 4) {
$possible_roles = [
				0 => "",
				1 => "student", 
				2 => "scientific coworker", 
				3 => "professor",
				4 => "admin",
];
foreach ($possible_roles as $value => $role) { ?>
<option value="<?= $value ?>"><?= $role ?></option>
<?php
}
}
?>
