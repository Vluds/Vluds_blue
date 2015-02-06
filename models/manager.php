<div id="manage-container" style="display: none;">
<?php

if(User::isLogged()) {

	if (User::getUserrole() == 1) {

	?>
		<table>
			<tr>
				<th>ID</th>
				<th>User ID</th>
				<th>Content</th>
				<th>Action</th>
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
			<tr>
				<td><?php echo $getPublicationInfos['id']; ?></td>
				<td><?php echo $getPublicationInfos['user_id']; ?></td>
				<td><?php echo $chaine; ?></td>
				<td><button onClick="deletePublication(<?php echo $getPublicationInfos['id']; ?>)">DELETE</button></td>
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