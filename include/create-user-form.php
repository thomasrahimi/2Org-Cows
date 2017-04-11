<form action="./scripts/create_user_script.php" method="POST">
				<table>
					<tr><td>Full name of user *</td><td><input type="text" name="fullname" required /></td></tr>
					
					<tr><td>Username *</td>
						<td><div class="tooltip"><input type="text" name="username" required /><span class="tooltiptext">Please choose a small letter username</span>
							</div>
						</td>
					</tr>
					<tr><td>Password *</td><td><input type="password" name="password" required /></tr>
					<tr><td>Repeat Password *</td><td><input type="password" name="repeat_password" required /></td>
					<td>
						<script type="text/javascript">checkPasswords()</script>
					</td>
					</tr>
					<tr><td>E-Mail *</td><td><input type="email" name="user_email" required /></td></tr>
					<tr><td>Phone Number *</td><td><input type="text" name="phone_number" required /></td></tr>
					<tr><td>User Role *</td><td><select name="user_role">
								<?php
								include_once("./include/choose-user-role.php");
								?>
														</select></td></tr>
					<tr><td>Institution and Department *</td><td>
								<?php //this code allows users with higher rights to create users in other institutions
									if($user_role > 2) {
										?>
										<select name="group">
										<?php
										$sql1 = "SELECT ID_Group, Group_Institution, Group_Department FROM Dim_Group"; // condition syntax: WHERE id = 'Group_Institution'
										$institutions = $agri_star_001->query($sql1);
										while ($possible_institutions = $institutions->fetch_assoc()) { ?>
											<option value="<?= intval($possible_institutions['ID_Group']) ?>"><?= $possible_institutions["Group_Institution"] ?> - 
											<?= $possible_institutions["Group_Department"] ?></option>
								<?php
									}								 
								?>
												</select>
								<?php
								} else {
										?>
										You are not allowed to choose another institution than yours
										<input type="hidden" name="group" value="<?= intval($_SESSION["group"]) ?>" />
										<?php
									}
									?>
												</td></tr>
					<tr><td>* = Fields are mandatory</td></tr>
					</table>
					<?php
			 			$_SESSION["user_token"] = uniqid();
					?>
					<input type="hidden" name="user_token" value="<?= hash_hmac('sha256', 'user_form', $_SESSION["user_token"]) ?>"/>
					<input type="submit" name="create_user" value="create user" formaction="./scripts/create_user_script.php"/>
</form>