	<?php 
		include "includes/header.php"; 
		include "templates/function.php";        
        if(isset($_SESSION["auth_user"])){
			$nowAuthUser = $_SESSION["auth_user"];
            $query = "SELECT user_group FROM user WHERE `login` = '{$nowAuthUser}'";
            $result = mysqli_query($connection, $query);
            $row = mysqli_fetch_assoc($result);
            $user_group = $row['user_group'];
        }else{
            $user_group = '0';
        }
        if($user_group == 3) {
	?>
		<div class="wrapperLK">
			<div class="contentLK">
				<div class="editForm">
					<form action="server/update.php" method="post">
						<?php if(isset($_GET["edit"])){
							$user_id = $_GET["edit"];
							$user = "SELECT * FROM user WHERE `user_id` = '{$user_id}'";
							$select_user = mysqli_query($connection, $user);
							$row_user = mysqli_fetch_assoc($select_user);
							$user_group = $row_user["user_group"];	
							$nickname = $row_user["nickname"];

							$queryGrName = "SELECT group_name FROM user_group WHERE `group_id` = '{$user_group}'";
							$select_GrName = mysqli_query($connection, $queryGrName);
							$capability_assoc = mysqli_fetch_assoc($select_GrName);
							$capability = $capability_assoc["group_name"];
						?>
						<p>
							<label for="nickname">Nickname:</label>
							<input name="nickname" id="nickname" type="text" value="<?php echo ($nickname);?>">
						</p>
						<p>
							<label for="capability">Capability</label>
							<input name="capability" id="capability" type="text" value=<?php echo ($capability);?> readonly>
							<input type="hidden" name="user_id" value= "<?php echo $user_id?>">
						</p>
						<p>
							<label for="new_capability:">Capability change:</label>
							<select id="new_capability" name = "newcapability">
								<option value="1">subscriber</option>
								<option value="2">moderator</option>
								<option value="3">administrator</option>
							</select>
						</p>
						<?php }else{?>
							<p>
								<label for="nickname">Nickname:</label>
								<input name="nickname" id="nickname" type="text" readonly>
							</p>
							<p>
								<label for="capability">Capability</label>
								<input name="capability" id="capability" type="text" readonly>
							</p>
						<?php }?>
						<div id="btnInfoUpdate">
							
							<button name = "btn_update" id="btnUpdate" type="submit">Update user data</button>
						</div>
					</form>
				</div>
			</div>
			<div class="contentLK">
				<table class="tableCapability">
					<thead>
						<tr class = "headTable">
							<th>Nickname</th>
							<th>Capability</th>
							<th></th>
						</tr>
					</thead>
					<tbody class = "bodyTable">
						<?php 
							findAllCategories();
						?>
					</tbody>
				</table>
			</div>
		</div>
		<?php }else{ 
			?>
				<div class="wrapperRoleLK">
					<div class="contentLK">
						<h1>Права текущего аккаунта не позволяют пользоваться ЛК</h1>
					</div>
				</div>
   		<?php } ?>
	<?php include "includes/footer.php"; ?>