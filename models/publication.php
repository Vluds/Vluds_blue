<div id="<?php echo $getPublication['id'];?>" class="publication<?php if(empty($getPublication['ext'])){echo " minimized";}?>" type="" style="display: none;">
<?php
	if(User::isLogged())
	{
		if($getUserInfos['token'] == User::getToken())
		{
?>
			<div class="more">
				<img src="img/more_icon.png">
			</div>

			<div class="menu">	
				<li onClick="deletePublication(<?php echo $getPublication['id'];?>)"><p>Supprimer</p></li>
			</div>
<?php
		}
	}
?>
<?php
	if(!empty($getPublication['ext']))
	{
?>
		<div class="cover" style="background-image: url('publications/<?php echo $getPublication['id'];?>/coverBlured_<?php echo $getPublication['token'];?>.png'); background-repeat: no-repeat; background-position: center center; background-size: cover;"> 
			
	<?php 
		if($getPublication['type'] == 'image')
		{
	?>
			<img src="publications/<?php echo $getPublication['id'];?>/cover_<?php echo $getPublication['token'];?>.png" alt="cover-<?php echo $getPublication['id']?>"/>
	<?php
		}
		else if($getPublication['type'] == 'audio')
		{
	?>
			<audio controls="controls">
			  	<source src="publications/<?php echo $getPublication['id'];?>/<?php echo $getPublication['token'];?>.<?php echo $getPublication['ext'];?>" type="<?php echo $getPublication['MIME'];?>" />
				Veuillez mettre à jour votre navigateur
			</audio>

			<div class="align-middle">
				
			</div>
	<?php
		}
		else if($getPublication['type'] == 'video')
		{
	?>
			<video controls="controls">
				<source src="publications/<?php echo $getPublication['id'];?>/<?php echo $getPublication['token'];?>.<?php echo $getPublication['ext'];?>" type="<?php echo $getPublication['MIME'];?>" />
			  	Veuillez mettre à jour votre navigateur
			</video>

			<div class="align-middle">
				
			</div>
	<?php
		}
	?>
			
			<div class="options">
				<div class="align-middle">
				</div>
				<?php
					if(User::isLiked(User::getId(), $getPublication['id']))
					{
				?>		
						<div class="like liked">
							<div class="hover liked">
							</div>
						</div>
				<?php
					}
					else
					{
				?>
						<div class="like unliked">
							<div class="hover unliked">
							</div>
						</div>
				<?php

					}
				?>
			</div>
		</div>
<?php
	}
?>
	<div class="infos">
		<div class="profil">
			<div class="avatar">
				<?php
					if(!empty($getUserInfos['avatar']) AND $getUserInfos['avatar'] != "0")
					{
				?>
						<img src="users/<?php echo $getUserInfos['id'];?>/avatar/60_<?php echo $getUserInfos['avatar'];?>.png">
				<?php
					}
					else
					{
				?>
						<img src="img/avatar.png">
				<?php
					}
				?>
			</div>

			<div class="username" onClick="loadProfil('<?php echo $getUserInfos['username']; ?>')">
				<?php
					if(!empty($getUserInfos['firstname']) AND !empty($getUserInfos['lastname'])) 
					{
				?>
						<h3><?php echo $getUserInfos['firstname'];?> <?php echo $getUserInfos['lastname'];?></h3>
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

		<div class="time">
			<p><?php echo Engine::EllapsedTime($getPublication['time']);?></p>
		</div>

		<div class="description">	
			<p><?php echo $getPublication['content'];?></p>
			<div class="blured-shadow">
				
			</div>
		</div>

		<div class="tags-container">
		<?php
			echo Engine::getTags($getPublication['id'], 6);
		?>
		</div>
	</div>
</div>