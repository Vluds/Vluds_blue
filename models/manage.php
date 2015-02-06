<div id="profil-container" style="display: none;">
<?php

if(User::isLogged()) {

	if (isset($getUserInfos['admin']) AND $getUserInfos['admin'] == 1) {

		echo "bienvenue admin";
		
	}

};

?>
</div>