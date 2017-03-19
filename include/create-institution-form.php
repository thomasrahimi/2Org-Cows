<form method="POST" action="./scripts/create_institution_script.php">
			<table>
				<tr>
					<td>Enter the name of the institution</td>
					<td><input type="text" name="new_institution" required /></td>
				</tr>
				<tr>
					<td>Department</td>
					<td><input type="text" name="department" required /></td>
				</tr>
				<tr>
					<td>Name of your working group</td>
					<td><input type="text" name="working_group_long" required /></td>
				</tr>
				<tr>
					<td>Short Name of your working group</td>
					<td><input type="text" name="working_group_short" required /></td>
				</tr>
				<tr>
					<td>Address</td>
				</tr>
				<tr>
					<td>Street</td>
					<td><input type="text" name="street" required /></td>
				</tr>
				<tr>
					<td>Postal Code</td>
					<td><input type="text" name="post-code" required /></td>
				</tr>
				<tr>
					<td>Town</td>
					<td><input type="text" name="town" required /></td>
				</tr>
				<tr><td>Country</td><td><select name="country">
													<?php
													$sql2 = "SELECT `Country_NameLong` FROM Dim_Country";
													$countries = $agri_star_001->query($sql2);
													while ($country_array = $countries->fetch_assoc()){
													?>
													<option value="<?= $country_array["Country_NameLong"] ?>"><?= $country_array["Country_NameLong"] ?></option>
													<?php
														}
													?>
													</select>
											</td>
				</tr>
				<tr>
					<td>Accountable Person</td>
					<td><input type="text" name="accountable_person" required /></td>
				</tr>
				<tr>
					<td>E-Mail Address</td>
					<td><input type="email" name="institution_email" required /></td>
				</tr>
				<tr>
					<td>Phone Number</td>
					<td><input type="text" name="phone_number" required /></td>
				</tr>
			</table>
			<?php
			 	$_SESSION["group_token"] = uniqid();
			?>
			<input type="hidden" name="group_token" value="<?= hash_hmac('sha256', 'create_group', $_SESSION["group_token"]) ?>"/>
			<!--Here the security token for the csrf protection is generated. Therefore, a SHA256 hash with a random number and the word 
			'create_group' is created -->
			<input type="submit" name="create_institution" formaction="./scripts/create_institution_script.php" value="create institution" />
</form>