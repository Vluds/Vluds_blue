<div id="manage-container" style="display: none;">
<?php

if(User::isLogged()) {

	if (User::getUserrole() == 1) {

		?>
		<table>
			<tr>
				<th><p>ID</p></th>
				<th><p>User ID</p></th>
				<th><p>Content</p></th>
				<th><p>Action</p></th>
			</tr>
		<?php

				$PublicationInfos = $newStaticBdd->select("*", "publications", "");
		        while ($getPublicationInfos = $newStaticBdd->fetch_array($PublicationInfos)) {

		        	if( strlen($getPublicationInfos['content']) >= 40 ) {

						$chaine = substr($getPublicationInfos['content'],0,40);

					} else {

						$chaine = $getPublicationInfos['content'];

					}

					?>
						<tr class="publication_manage" id="<?php echo $getPublicationInfos['id']; ?>">
							<td><p><?php echo $getPublicationInfos['id']; ?></p></td>
							<td><p><?php echo $getPublicationInfos['user_id']; ?></p></td>
							<td><p><?php echo $chaine; ?></p></td>
							<td><p><button onClick="deletePublicationManage(<?php echo $getPublicationInfos['id']; ?>)">DELETE</button></p></td>
						</tr>
					<?php

				}

		?>
		</table>
		<table>
			<tr>
				<th><p>ID</p></th>
				<th><p>Role</p></th>
				<th><p>Username</p></th>
				<th><p>Action</p></th>
			</tr>
		<?php

				$userInfos = $newStaticBdd->select("*", "users", "");
		        while ($getUserInfos = $newStaticBdd->fetch_array($userInfos)) {

					?>
						<tr class="user" id="<?php echo $getUserInfos['id']; ?>">
							<td><p><?php echo $getUserInfos['id']; ?></p></td>
							<td><p><?php echo $getUserInfos['role']; ?></p></td>
							<td><p><?php echo $getUserInfos['username']; ?></p></td>
							<td><p><button onClick="deleteUser(<?php echo $getUserInfos['id']; ?>)">DELETE</button></p></td>
						</tr>
					<?php

				}

		?>
		</table>
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