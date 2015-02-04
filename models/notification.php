<div class="notification" id="<?php echo $getNotifications['id'];?>" href="<?php echo $getNotifications['url'];?>">
	<div class="content">
		<div class="text" href="<?php echo $getNotifications['url'];?>">
			<p><?php echo $getNotifications['content']; ?></p>
		</div>
		<div class="date">
			<p><?php echo Engine::ellapsedTime($getNotifications['time']); ?></p>
		</div>
	</div>
</div>