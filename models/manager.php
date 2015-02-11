<div id="manage-container" style="display: none;">
<?php

if(User::isLogged()) {

	if (User::getUserrole() == 1) {

		?>
		<div class="table_container">
			<table class="manager manager_table manager_table--publication">
				<tr>
					<th>ID</th>
					<th>User ID</th>
					<th>Content</th>
					<th>Action</th>
				</tr>
			<?php

					$PublicationInfos = $newStaticBdd->select("*", "publications", "ORDER BY ID DESC");
			        while ($getPublicationInfos = $newStaticBdd->fetch_array($PublicationInfos)) {

			        	if( strlen($getPublicationInfos['content']) >= 40 ) {

							$chaine = substr($getPublicationInfos['content'],0,40);

						} else {

							$chaine = $getPublicationInfos['content'];

						}

						?>
							<tr class="publication_manage" id="<?php echo $getPublicationInfos['id']; ?>">
								<td><?php echo $getPublicationInfos['id']; ?></td>
								<td><?php echo $getPublicationInfos['user_id']; ?></td>
								<td><?php echo $chaine; ?></td>
								<td><button onClick="deletePublicationManage(<?php echo $getPublicationInfos['id']; ?>)">DELETE</button></td>
							</tr>
						<?php

					}

			?>
			</table>
		</div>
		<div class="table_container">
			<table class="manager manager_table manager_table--user">
				<tr>
					<th>ID</th>
					<th>Role</th>
					<th>Username</th>
					<th>Action</th>
				</tr>
			<?php

					$userInfos = $newStaticBdd->select("*", "users", "ORDER BY ID DESC");
			        while ($getUserInfos = $newStaticBdd->fetch_array($userInfos)) {

						?>
							<tr class="user" id="<?php echo $getUserInfos['id']; ?>">
								<td><?php echo $getUserInfos['id']; ?></td>
								<td><?php echo $getUserInfos['role']; ?></td>
								<td><?php echo $getUserInfos['username']; ?></td>
								<td><button onClick="deleteUser(<?php echo $getUserInfos['id']; ?>)">DELETE</button></td>
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