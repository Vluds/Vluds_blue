<div class="comment" id="<?php echo $getComments['id'];?>">
	<div class="profil">
		<div class="avatar" onClick="loadProfil('<?php echo $getUserInfos['username']; ?>')">
			<?php
				if(!empty($getUserInfos['avatar']) AND $getUserInfos['avatar'] != "0")
				{
			?>
					<img src="<?php echo WEBROOT; ?>users/<?php echo $getUserInfos['id'];?>/avatar/60_<?php echo $getUserInfos['avatar'];?>.png">
			<?php
				}
				else
				{
			?>
					<img src="<?php echo WEBROOT; ?>img/avatar.png">
			<?php
				}
			?>

			<div class="align-middle">
					
			</div>
		</div>

		<div class="username" onClick="loadProfil('<?php echo $getUserInfos['username']; ?>')">
			<?php
				if(isset($getUserInfos['firstname']) AND isset($getUserInfos['lastname']))
				{
			?>
					<div class="firstname">
						<h3><?php echo $getUserInfos['firstname'];?></h3>
					</div>

					<div class="lastname">
						<h3><?php echo $getUserInfos['lastname']?></h3>
					</div>
			<?php
				}
				else
				{
			?>
					<div class="username">
						<h3><?php echo $getUserInfos['username'];?></h3>
					</div>
			<?php
				}
			?>
		</div>
	</div>

	<div class="content-container">
		<p><?php echo $getComments['content'];?></p>
	</div>

	<div class="date">
		<p><?php echo Engine::ellapsedTime($getComments['time']);?></p>
	</div>

	<div>
	<?php
		if(User::isLogged())
		{
			if($getUserInfos['token'] == User::getToken())
			{
	?>
				<div class="more">
					<img src="<?php echo WEBROOT; ?>img/more_icon.png">
				</div>

				<div class="menu">		
					<li onClick="deleteComment(<?php echo $getComments['id'];?>)"><p>Supprimer</p></li>
				</div>
	<?php
			}
		}
	?>
	</div>
</div>