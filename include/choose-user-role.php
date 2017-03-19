<?php
if($user_role < 4) {
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
else {
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