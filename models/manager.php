<div id="manage-container" style="display: none;">
<?php

if(User::isLogged()) {

	if (User::getUserrole() == 1) {

		?>
		<div class="table_container">
			<table class="manager manager_table manager_table--publication">
				<tr>
					<th class="manager_table__th__id">ID</th>
					<th class="manager_table__th__userid">User ID</th>
					<th>Content</th>
					<th class="manager_table__th__action">Action</th>
				</tr>
			<?php

					$PublicationInfos = $newStaticBdd->select("*", "publications", "ORDER BY ID DESC");
			        while ($getPublicationInfos = $newStaticBdd->fetch_array($PublicationInfos)) {

			        	if( strlen($getPublicationInfos['content']) >= 100 ) {

							$chaine = substr($getPublicationInfos['content'],0,100);

						} else {

							$chaine = $getPublicationInfos['content'];

						}

						?>
							<tr class="manager_table__publication" id="<?php echo $getPublicationInfos['id']; ?>">
								<td class="manager_table__td"><?php echo $getPublicationInfos['id']; ?></td>
								<td class="manager_table__td"><?php echo $getPublicationInfos['user_id']; ?></td>
								<td class="manager_table__td manager_table__publication__text"><?php echo $chaine; ?></td>
								<td class="manager_table__td"><button class="manager_table__td__button" onClick="deletePublicationManage(<?php echo $getPublicationInfos['id']; ?>)">X</button></td>
							</tr>
						<?php

					}

			?>
			</table>
		</div>
		<div class="table_container">
			<table class="manager manager_table manager_table--user">
				<tr>
					<th class="manager_table__th__id">ID</th>
					<th>Role</th>
					<th>Avatar</th>
					<th>Username</th>
					<th class="manager_table__th__action">Action</th>
					<th class="manager_table__th__admin">Admin</th>
				</tr>
			<?php

					$userInfos = $newStaticBdd->select("*", "users", "ORDER BY ID DESC");
			        while ($getUserInfos = $newStaticBdd->fetch_array($userInfos)) {

			        	if ($getUserInfos['role'] == 1) {
			        		$rolestatut = '✓';
			        		$roleclass = 'true';
			        	} else {
			        		$rolestatut = 'X';
			        		$roleclass = 'false';
			        	}

						?>
							<tr class="manager_table__user" id="<?php echo $getUserInfos['id']; ?>">
								<td class="manager_table__td"><?php echo $getUserInfos['id']; ?></td>
								<td class="manager_table__td"><?php echo $getUserInfos['role']; ?></td>
								<td class="manager_table__user__td">
									<?php
										if(!empty($getUserInfos['avatar']) AND $getUserInfos['avatar'] != "0") {
									?>
										<img src="<?php echo WEBROOT; ?>users/<?php echo $getUserInfos['id'];?>/avatar/300_<?php echo $getUserInfos['avatar'];?>.png">
									<?php
										} else {
									?>
										<img src="<?php echo WEBROOT; ?>img/avatar.png">
									<?php
										}
									?>
								</td>
								<td class="manager_table__td"><?php echo $getUserInfos['username']; ?></td>
								<td class="manager_table__td"><button class="manager_table__td__button" onClick="deleteUser(<?php echo $getUserInfos['id']; ?>)">X</button></td>
								<td class="manager_table__td"><button class="manager_table__td__button__admin manager_table__td__button__admin--<?php echo $roleclass; ?>" id="<?php echo $getUserInfos['id']; ?>" onClick="changeUserRole('<?php echo $getUserInfos['id']; ?>', '<?php echo $roleclass; ?>');"><?php echo $rolestatut; ?></button></td>
							</tr>
						<?php

					}

			?>
			</table>
		</div>
		<?php
			
	}

} else {

?>
<script type="text/javascript">
	getFlux();
</script>
<?php

}

?>
</div>