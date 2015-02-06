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
	<tr>
		<td><p><?php echo $getPublicationInfos['id']; ?></p></td>
		<td><p><?php echo $getPublicationInfos['user_id']; ?></p></td>
		<td><p><?php echo $chaine; ?></p></td>
		<td><p><button onClick="deletePublication(<?php echo $getPublicationInfos['id']; ?>)">DELETE</button></p></td>
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