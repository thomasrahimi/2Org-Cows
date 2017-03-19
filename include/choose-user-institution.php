<?php //this code allows users with higher rights to create users in other institutions
if($user_role > 2) {
	$institutions_query_prepare = mysqli_prepare($agri_star_001, "SELECT ID_Group, Group_Institution FROM Dim_Group WHERE id = 'Group_Institution'"); //query the Dim_Group table to gain all institutions
	$institution_query = mysqli_query($agri_star_001, $institution_query_prepare);
	while ($possible_institutions = mysqli_fetch_assoc($institution_query)) { ?>
		<option value="<?= $possible_institution["ID_Group"] ?>"><?= $possible_institution["Group_Institution"] ?></option>
<?php
	}
} if($user_role == 2) {
		$institution_creator = $_SESSION["institution"];//if the user does not have the right to create users at other institutions, the own institution is set
?>	
<input type="text" name="institution" value="<?= $institution_creator ?>" readonly/>
<?php
	}
?>