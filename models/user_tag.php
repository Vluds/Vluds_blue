<div class="tag" name="<?php echo $getUserTag['name'];?>" id="<?php echo $getUserTag['id'];?>">
<?php 
	if(User::isLogged()) 
	{

		if($getUserTag['user_id'] == User::getId())
		{
?>
			<div class="remove">
				<img src="<?php echo WEBROOT; ?>img/cross.png">
			</div>
<?php 
		}
	}
?>
	<div class="content">
		<p><?php echo $getUserTag['name'];?></p>
	</div>
</div>