<div id="publicationViewer" class="box" ref="<?php echo $getPublicationInfos['id'];?>">
	<div id="container">
		<div class="close"><img src="<?php echo WEBROOT; ?>img/cross.png"></div>
<?php
	if($getPublicationInfos['type'] == 'image')
	{
?>
		<div id="cover">
			<div id="cover-container" style="background-image: url('<?php echo WEBROOT; ?>publications/<?php echo $getPublicationInfos['id'];?>/coverBlured_<?php echo $getPublicationInfos['token'];?>.png');">
				<img alt="cover-<?php echo $getPublicationInfos['id'];?>" src="<?php echo WEBROOT; ?>publications/<?php echo $getPublicationInfos['id'];?>/cover_<?php echo $getPublicationInfos['token'];?>.png">
			</div>
			<div id="hover">
				<div id="expand" onclick="loadPublicationPage('<?php echo $getPublicationInfos['id'];?>')">
					
				</div>
				<div class="align-middle">
					
				</div>
			</div>
		</div>
<?php
	}
?>

		<div id="infos-container">
			<div id="top-container">
				<div id="profil">
					<div class="avatar">
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
					</div>

					<div class="username" onClick="loadProfil('<?php echo $getUserInfos['username']; ?>')">
						<?php
							if(isset($getUserInfos['fullname']) AND !empty($getUserInfos['fullname'])) 
							{
						?>
								<h3><?php echo $getUserInfos['fullname'];?></h3>
						<?php
							}
							else
							{
						?>
								<h3><?php echo $getUserInfos['username'];?></h3>
						<?php
							}
						?>
					</div>
				</div>
				<div id="time">
					<p><?php echo Engine::EllapsedTime($getPublicationInfos['time']);?></p>
				</div>
			</div>
			<div id="description">
				<p><?php echo $getPublicationInfos['content'];?></p>
			</div>

			<div id="tags-container">
				<?php echo Engine::getTags($getPublicationInfos['id'], 6);?>
			</div>

			<div class="separator">
			</div>

			<div id="comments-container">
			<?php
				if(User::isLogged())
				{
			?>
					<div id="post-comment" ref="<?php echo $getPublicationInfos['id'];?>">
						<div id="avatar">
							<?php
								if(!empty(User::getAvatar()) AND User::getAvatar() != "0")
								{
							?>
									<img src="<?php echo WEBROOT; ?>users/<?php echo User::getId();?>/avatar/60_<?php echo User::getAvatar();?>.png">
							<?php
								}
								else
								{
							?>
									<img src="<?php echo WEBROOT; ?>img/avatar.png">
							<?php
								}
							?>

							<div class="left-arrow">
							</div>
						</div>

						<div id="post-content">
							<div id="textarea-container">
								<textarea spellcheck="true" placeholder="Réagir à propos de cette publication" class="resize-auto"></textarea>
							</div>
							<div id="submit-comment">
								<input type="submit" value="Poster">
							</div>
						</div>
					</div>
			<?php
				}
				else
				{
			?>
					<p>Connectez-vous pour pouvoir commenter</p>
			<?php
				}
			?>
				<div id="comments-content">
					<?php 
						echo Engine::getComments($getPublicationInfos['id'], 10);
					?>
				</div>
			</div>
		</div>
	</div>
</div>