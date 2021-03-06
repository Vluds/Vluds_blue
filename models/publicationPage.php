<div id="publicationviewer-container" ref="<?php echo $getPublication['id'];?>" style="display: none;">
	<div class="loading">
	</div>
<?php
	if(!empty($getPublication['ext']))
	{
?>
	<div id="cover" style="background-image: url('<?php echo WEBROOT; ?>publications/<?php echo $getPublication['id'];?>/coverBlured_<?php echo $getPublication['token'];?>.png')">
		<?php 
			if($getPublication['type'] == 'image')
			{
		?>
				<img src="<?php echo WEBROOT; ?>publications/<?php echo $getPublication['id'];?>/<?php echo $getPublication['token'];?>.<?php echo $getPublication['ext'];?>" alt="image-<?php echo $getPublication['id']?>"/>
		<?php
			}
			else if($getPublication['type'] == 'audio')
			{
		?>
				<audio controls="controls">
				  	<source src="<?php echo WEBROOT; ?>publications/<?php echo $getPublication['id'];?>/<?php echo $getPublication['token'];?>.<?php echo $getPublication['ext'];?>" type="<?php echo $getPublication['MIME'];?>" />
					Veuillez mettre à jour votre navigateur
				</audio>
		<?php
			}
			else if($getPublication['type'] == 'video')
			{
		?>
				<video controls="controls">
					<source src="<?php echo WEBROOT; ?>publications/<?php echo $getPublication['id'];?>/<?php echo $getPublication['token'];?>.<?php echo $getPublication['ext'];?>" type="<?php echo $getPublication['MIME'];?>" />
				  	Veuillez mettre à jour votre navigateur
				</video>
		<?php
			}
		?>
		<div class="align-middle">
			
		</div>
	</div>
<?php
	}
?>
	<div id="content">
		<div id="profil" onClick="loadProfil('<?php echo $getUserInfos['username']; ?>')">
			<?php
				if(isset($getUserInfos['fullname']) AND !empty($getUserInfos['fullname']))
				{
			?>
					<div id="fullname">
						<h3><?php echo $getUserInfos['fullname'];?></h3>
					</div>
			<?php
				}
				else
				{
			?>
					<div id="username">
						<h3><?php echo $getUserInfos['username'];?></h3>
					</div>
			<?php
				}
			?>

			<div id="avatar">
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
		</div>

		<div id="date">
			<p><?php echo Engine::ellapsedTime($getPublication['time']);?></p>
		</div>

		<div id="infos">
			<div id="description">
				<p><?php echo $getPublication['content'];?></p>
			</div>

			<div id="tags-container">
				<?php echo Engine::getTags($getPublication['id'], 10);?>
			</div>

			<div class="separator">
			</div>
		</div>

		<div id="comments-container">
			<div id="title">
				
			</div>
		<?php
			if(User::isLogged())
			{
		?>
				<div id="post-comment" ref="<?php echo $getPublication['id'];?>">
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
					echo Engine::getComments($getPublication['id'], 10);
				?>
			</div>
		</div>
	</div>
</div>