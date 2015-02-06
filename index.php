<?php
	session_start();

	// Get site url.
	$siteProtocol = strpos(strtolower($_SERVER['SERVER_PROTOCOL']),"https") === FALSE ? "http" : "https";
	$siteHost = $_SERVER['HTTP_HOST'];
	$siteUrl = $siteProtocol."://".$siteHost;
	define('URL', $siteUrl, true);

	// Define directory.
	define('ROOT', str_replace('index.php', '', $_SERVER['SCRIPT_FILENAME']), true);
	define('WEBROOT', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), true);

	define('INCLUDES', ROOT.'includes/', true);
	define('PHP', ROOT.'src/php/', true);

	define('SCRIPT', WEBROOT.'src/js/', true);
	define('LIB', WEBROOT.'src/js/lib/', true);
	define('STYLE', WEBROOT.'css/', true);
	define('IMG', WEBROOT.'img/', true);

	// Define social link.
	define('TWITTER', 'https://www.twitter.com/mxcmaxime', true);
	define('YOUTUBE', 'https://www.youtube.com/user/mxcmaxime', true);
	define('BEHANCE', 'https://www.behance.net/mxcmaxime', true);
	define('FACEBOOK', 'https://www.facebook.com/mxcmaxime.fr', true);

	require(PHP."class/bdd.php");
	require(PHP."class/Engine.php");
	require(PHP."class/User.php");

	$newBdd = new BDD();
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
			require(INCLUDES."head.php");
		?>
	</head>

	<body>
		<header>

		</header>

		<div id="slideBar">
			
		</div>

		<section id="sidebar" class="active">
			<div class="loading">
			</div>

			<ul id="top">
				<li onClick="getFlux()"><h1>vluds</h1></li>
			</ul>

			<script type="text/javascript">
				loadSideBar();
			</script>
		</section>

		<section id="include-container">
			<?php
				if(isset($_GET['username']) AND !empty($_GET['username'])) 
				{	
			?>	
					<script type="text/javascript">
						loadProfil('<?php echo $_GET['username']; ?>');
					</script>
			<?php
				}
				else if(isset($_GET['tag']) AND !empty($_GET['tag'])) 
				{	
			?>	
					<script type="text/javascript">
						loadTagsFinder('<?php echo $_GET['tag']; ?>');
					</script>
			<?php
				}
				else if(isset($_GET['publication']) AND !empty($_GET['publication'])) 
				{	
			?>	
					<script type="text/javascript">
						loadPublicationViewer('<?php echo $_GET['publication']; ?>');
					</script>
			<?php
				}
				else if(isset($_GET['manager']) AND !empty($_GET['manager'])) 
				{	
			?>	
					<script type="text/javascript">
						loadManager();
					</script>
			<?php
				}
				else
				{
			?>
					<script type="text/javascript">
						getFlux();
					</script>
			<?php
				}
			?>

		</section>

		<div id="messageBox_container">
				
		</div>

		<?php
			require(INCLUDES."regBox.php");
			require(INCLUDES."logBox.php");
			require(INCLUDES."cookiesBox.php");
		?>

		<div id="module-container">
			<script type="text/javascript">
				loadFile('postPublication', '#module-container');
				loadFile('publicationViewer', '#module-container');
			</script>
		</div>

		<div id="backgroundBox"></div>

		<!--JQuery Scripts-->
		<script src="<?php echo SCRIPT; ?>JAnimate.js"></script>
		<script src="<?php echo SCRIPT; ?>JEngine.js"></script>

		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-57154908-1', 'auto');
		  ga('send', 'pageview');

		</script>
	</body>
</html>