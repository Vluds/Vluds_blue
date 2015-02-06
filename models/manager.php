<div id="manage-container" style="display: none;">
<?php

if(User::isLogged()) {

	if (User::getUserrole() == 1) {

	?>
		<table>
			<tr>
				<th>ID</th>
				<th>User</th>
				<th>Content</th>
				<th>Action</th>
			</tr>
			<tr><td></td></tr>
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