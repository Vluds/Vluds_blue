<div id="<?php echo $getProfilInfos['id'];?>" class="publication profil" type="">
	<div class="infos">
		<div class="banner" >
			<?php
				if(!empty($getProfilInfos['banner']))
				{
			?>
					<img src="<?php echo WEBROOT; ?>users/<?php echo $getProfilInfos['id'];?>/banner/800_<?php echo $getProfilInfos['banner'];?>.png" alt="banner-<?php echo $getProfilInfos['id'], '-', $getProfilInfos['username'];?>"/>
			<?php
				}
				else
				{
			?>
					<img src="<?php echo WEBROOT; ?>img/default_banner.png" alt="banner-default"/>
			<?php
				}
			?>
		</div>

		<div class="profil">
			<div class="avatar">
				<?php
					if($getProfilInfos['avatar'] != "0" AND !empty($getProfilInfos['avatar']))
					{
				?>
						<img src="<?php echo WEBROOT; ?>users/<?php echo $getProfilInfos['id'];?>/avatar/60_<?php echo $getProfilInfos['avatar'];?>.png">
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

			<div class="username" onClick="loadProfil('<?php echo $getProfilInfos['username']; ?>')">
				<?php
					if(isset($getProfilInfos['fullname']) AND !empty($getProfilInfos['fullname']))
					{
				?>
						<div id="fullname">
							<h3><?php echo $getProfilInfos['fullname'];?></h3>
						</div>
				<?php
					}
					else
					{
				?>
						<div id="username">
							<h3><?php echo $getProfilInfos['username'];?></h3>
						</div>
				<?php
					}
				?>
			</div>
		</div>

		<div class="text">
			<p>Cette personne pourrait vous intéresser</p>
		</div>

		<div class="tags-container">	
			<?php
				echo Engine::getUserTags($getProfilInfos['id'], 10);
			?>
		</div>
	</div>
</div>