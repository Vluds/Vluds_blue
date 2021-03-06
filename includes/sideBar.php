<?php
	$newBdd = new BDD();
?>
<div id="sidebar_ajax_container">
<?php
	if(User::isLogged())
	{
?>
		<div id="slider">
			<img src="<?php echo WEBROOT; ?>img/cross.png">
		</div>
<?php
	}
?>
	<ul id="profil">
		<?php		
			if(User::isLogged())
			{
		?>
				<div id="state" class="logged">
				</div>
		<?php
				if(!empty(User::getAvatar()) AND User::getAvatar() != "0")
				{
		?>
					<div id="avatar" class="activate">
						<img src="<?php echo WEBROOT; ?>users/<?php echo User::getId();?>/avatar/300_<?php echo User::getAvatar();?>.png">

						<div id="profilEdit" onClick="loadProfil('<?php echo User::getUsername(); ?>')">
							<div class="info">
								<p>Editer votre profil</p>
							</div>
						</div>
					</div>
		<?php
				}
				else
				{
		?>
					<div id="avatar" class="unactivate">
						<img src="<?php echo WEBROOT; ?>img/avatar.png">

						<div id="profilEdit" onClick="loadProfil('<?php echo User::getUsername(); ?>')">
							<div class="info">
								<p>Editer votre profil</p>
							</div>
						</div>
					</div>

		<?php
				}
				if(!empty(User::getFullName()))
				{
		?>
					<li id="username" onClick="loadProfil('<?php echo User::getUsername(); ?>')"><h3><?php echo User::getFullName();?></h3></li>
		<?php
				}
				else
				{
		?>
					<div id="addName">
						<div id="text-indication">
							<p>Ajouter votre nom</p>
						</div>

						<div class="input-container" id="fullname">
			<?php
						if(!empty(User::getFullName()))
						{
			?>
							<h3><?php echo User::getFullName();?></h3>
			<?php
						}
						else
						{
			?>
							<input type="text" placeholder="Ajouter votre nom"/><div class="check" onclick="setFullName()"><p>✓</p></div>
			<?php
						}
			?>
						</div>
					</div>
		<?php
				}
			}
			else
			{
		?>
				<div id="submit-container">
					<input id="sign" type="submit" value="Connectez-vous"/>
					<input id="reg" type="submit" value="Inscrivez-vous"/>
				</div>
		<?php
			}
		?>
	</ul>

	<nav>
		<ul>
			<li id="flux" class="unactive" onClick="getFlux()"><p>Flux d'actualité</p><div id="sort"><img src="<?php echo WEBROOT; ?>img/grid.png"></div></li>
			<li id="search" class="unactive" onClick="loadTagsFinder('<?php echo User::getUsername(); ?>')"><p>Rechercher</p></li>
		<?php
			if(User::isLogged())
			{
		?>
				<li id="profil" class="unactive" onClick="loadProfil('<?php echo User::getUsername(); ?>')"><p>Mon profil</p></li>
				<li id="notifications-li" class="unactive">
					<p>Notifications</p>

					<div class="left-arrow">
					</div>
				</li>
				<ul id="notifications-viewer">
					<div id="close">
						<img src="<?php echo WEBROOT; ?>img/cross.png">
					</div>

					<div id="content">			
					</div>
				</ul>
				<!--<li class="unactive"><a href=""><p>Mes favoris</p></a></li>
				<li class="unactive"><a href=""><p>Mes tags</p></a></li>
				<li class="unactive"><a href=""><p>Mes reglages</p></a></li>-->
		<?php
			if (User::getUserRole() == 1)
			{
		?>
				<li id="manager" class="unactive" onClick="loadManager()"><p>Manage</p></li>
		<?php
			}
		?>

				<div id="submit-artwork">
					<input type="submit" value="Ajouter une publication" onClick="loadPostPublication()"/>
				</div>
		<?php
			}
		?>
			<br/>
			<br/>
			<!--<li class="unactive"><a href=""><p>Voir les membres</p></a></li>-->
		</ul>
	</nav>
</div>