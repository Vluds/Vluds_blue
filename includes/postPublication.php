<div id="postPublication" class="box">
	<div class="close">
		<img src="img/cross.png">
	</div>

	<div class="container">
		<div class="avatar">
			<?php
				if(User::getAvatar())
				{
			?>
					<img src="users/<?php echo User::getId();?>/avatar/60_<?php echo User::getAvatar();?>.png">
			<?php	
				}
				else
				{
			?>
					<img src="img/avatar.png">
			<?php
				}
			?>

			<div class="bottom-arrow">
			</div>
		</div>

		<div class="options-container">

			<input id="file-upload" name="file-upload" type="file" multiple="multiple"></input>
			<div id="add-file" class="option-button">
				<img src="img/add_20.png">
				<div class="align-middle"></div>

				<div class="info">
					<p>Ajouter des fichiers</p>
				</div>
			</div>

			<div id="add-url" class="option-button">
				<img src="img/add_20.png">
				<div class="align-middle"></div>

				<div class="info">
					<p>Incruster un lien</p>
				</div>
			</div>

			<div class="align-middle"></div>
		</div>

		<div class="post-content">
			<textarea spellcheck="true" placeholder="Qu'avez-vous de beau à faire découvrir ?" class="resize-auto"></textarea>
		</div>

		<div class="file-viewer">
			<div class="object-slider">
				
			</div>
		</div>

		<div class="tags-container">
			<input type="text" placeholder="Ajouter des tags séparés d'un espace">
		</div>

		<div class="submit-publication">
			<input type="submit" value="Poster">
		</div>
	</div>
</div>