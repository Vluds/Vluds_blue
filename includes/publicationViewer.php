<div id="publicationViewer" class="box">
	<div class="close"><img src="<?php echo WEBROOT; ?>img/cross.png"></div>
	<div id="container">
		<div id="cover">
			<div id="cover-container">
				
			</div>
			<div id="hover">
				<div id="expand">
					
				</div>
				<div class="align-middle">
					
				</div>
			</div>
		</div>

		<div id="infos-container">
			<div id="top-container">
				<div id="profil">
						
				</div>
				<div id="time">
					
				</div>
			</div>
			<div id="description">
				
			</div>

			<div id="tags-container">
				
			</div>

			<div class="separator">
			</div>

			<div id="comments-container">
			<?php
				if(User::isLogged())
				{
			?>
					<div id="post-comment">
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
			</div>
		</div>
	</div>
</div>