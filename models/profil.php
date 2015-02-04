<div id="profil-container" style="display: none;">
<?php
	if(isset($getUserInfos['banner']) AND !empty($getUserInfos['banner']))
	{
?>
		<div id="banner" style="background-image: url('users/<?php echo $getUserInfos['id'];?>/banner/800_<?php echo $getUserInfos['banner'];?>.png');">
<?php
	}
	else
	{
?>
		<div id="banner" style="background-image: url('img/default_banner.png');">
<?php
	}
			if(User::isLogged())
			{
				if($getUserInfos['token'] == User::getToken())
				{
		?>
					<div id="changeBanner">
						<div class="info">
							<p>Modifier votre bannière</p>
						</div>
					</div>

					<input id="banner-upload" name="banner-upload" accept="image/*" type="file">
		<?php
				}
			}
		?>
		</div>

		<div id="profil">
			<div id="avatar">
				<?php
					if(!empty($getUserInfos['avatar']) AND $getUserInfos['avatar'] != "0")
					{
				?>
						<img src="users/<?php echo $getUserInfos['id'];?>/avatar/300_<?php echo $getUserInfos['avatar'];?>.png">
				<?php
					}
					else
					{
				?>
						<img src="img/avatar.png">
				<?php
					}

					if(User::isLogged())
					{
						if($getUserInfos['token'] == User::getToken())
						{
				?>
							<div id="addAvatar">
								<div class="info">
									<p>Modifier votre avatar</p>
								</div>
							</div>

							<input id="avatar-upload" name="avatar-upload" accept="image/*" type="file">
				<?php
						}
					}
				?>
			</div>

			<div id="infos">
				
			<?php
				if(User::isLogged())
				{
					if($getUserInfos['token'] != User::getToken())
					{
						if(User::isFollowed(User::getId(), $getUserInfos['id']))
						{
				?>
							<div class="follow-container" state="active" id="<?php echo $getUserInfos['id'];?>">
								<h3>Suivi</h3>
							</div>
				<?php
						}
						else
						{
				?>
							<div class="follow-container" state="unactivate" id="<?php echo $getUserInfos['id'];?>">
								<h3>Suivre</h3>
							</div>
				<?php
						}
					}
				}
				if(isset($getUserInfos['fullname']) AND !empty($getUserInfos['fullname']))
				{
			?>
					<div id="fullname">
						<h1><?php echo $getUserInfos['fullname'];?></h1>
					</div>
			<?php
				}
				else
				{
			?>
					<div id="username">
						<h1><?php echo $getUserInfos['username'];?></h1>
					</div>
			<?php
				}
			?>
				<div id="time">
					<p><?php echo Engine::ellapsedTime($getUserInfos['time']);?></p>
				</div>

				<div id="tags-container">
					<?php echo Engine::getUserTags($getUserInfos['id'], 10);?>
			<?php
				if(User::isLogged())
				{
					if($getUserInfos['token'] == User::getToken())
					{
			?>
						<div id="add-tag">
							<div id="text">
								<p>+ Ajouter un tag</p>
							</div>
							<div id="input-container">
								<input id="addtag-input" placeholder="Entrer pour valider" type="text">
								<img id="remove" src="img/cross.png">
							</div>
						</div>
			<?php
					}
				}
			?>
				</div>
			</div>
	</div>

	<div id="publication-container">
		<div class="loading">
		</div>

		<script type="text/javascript">
			getPublicationsByUserId(<?php echo $getUserInfos['id'];?>);
		</script>
	</div>
</div>