<?php
define('WEBROOT', str_replace('database-filler.php', '', $_SERVER['SCRIPT_NAME']), true);

class DatabaseFiller {

	private $pdo = null;

/*

####################################################
## SET HERE YOUR DATABASE CONNECTION CREDENTIAL ! ##
####################################################

*/	
	# HOST
	###############
	private $dbHost = '127.0.0.1';
	##############################

	# USERNAME
	###############
	private $dbUser = 'root';
	#########################

	# PASSWORD
	###############
	private $dbPass = '';
	#####################
/*

####################################################
####################################################
####################################################

*/






	private $dbName = 'vluds_bdd';

	private $names = array('Admin', 'Membre');
	private $images = array('10dcfeh2he', 'xhg56yp3ky');

	public function connect() {
		$this->pdo = new mysqli($this->dbHost, $this->dbUser, $this->dbPass);
		// Check connection
		if ($this->pdo->connect_error) {
			die("Connection failed: ".$this->pdo->connect_error);
		}
	}

	public function createDatabase() {

		$sql = "CREATE DATABASE IF NOT EXISTS `vluds_bdd`";
		$this->pdo->query($sql);

	}

	public function connectToDatabase() {

		$this->pdo = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName, $this->dbUser, $this->dbPass);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	}

	public function createTables() {

		$this->pdo->query("CREATE TABLE IF NOT EXISTS `answers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`comment_id` int(11) NOT NULL,
				`content` varchar(500) NOT NULL,
				`token` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `comments` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`publication_id` int(11) NOT NULL,
				`user_id` int(11) NOT NULL,
				`content` varchar(1000) NOT NULL,
				`token` varchar(255) NOT NULL,
				`time` int(11) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `followers` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`follower_id` int(11) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `likes` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`publication_id` int(11) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `notifications` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`url` varchar(255) NOT NULL,
				`content` varchar(500) NOT NULL,
				`read` int(11) NOT NULL,
				`time` int(11) NOT NULL,
				`token` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `publications` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`content` varchar(2000) NOT NULL,
				`ext` varchar(255) NOT NULL,
				`type` varchar(255) NOT NULL,
				`MIME` varchar(255) NOT NULL,
				`time` int(11) NOT NULL,
				`token` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `tags` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`publication_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `type` (
				`type_id` int(11) NOT NULL AUTO_INCREMENT,
				`name` varchar(255) NOT NULL,
				PRIMARY KEY (`type_id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `users` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`role` int(11) NOT NULL,
				`username` varchar(255) NOT NULL,
				`email` varchar(255) NOT NULL,
				`firstname` varchar(255) NOT NULL,
				`lastname` varchar(255) NOT NULL,
				`fullname` varchar(255) NOT NULL,
				`description` varchar(255) NOT NULL,
				`avatar` varchar(255) NOT NULL,
				`banner` varchar(255) NOT NULL,
				`password` varchar(255) NOT NULL,
				`salt` varchar(255) NOT NULL,
				`time` int(11) NOT NULL,
				`token` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

			CREATE TABLE IF NOT EXISTS `user_tags` (
				`id` int(11) NOT NULL AUTO_INCREMENT,
				`user_id` int(11) NOT NULL,
				`name` varchar(255) NOT NULL,
				`token` varchar(255) NOT NULL,
				PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");

	}

	public function randomSalt($nbChar) {

		$randString = "";
		$chars = "abcdefghijklmnpqrstuvwxy0123456789";
		srand((double)microtime()*1000000);

		for($i=0; $i < $nbChar; $i++) {
			$randString .= $chars[rand()%strlen($chars)];
		}

		return $randString;
	}

	public function randomName($nbChar) {

		$randString = "";
		$chars = "abcdefghijklmnpqrstuvwxy";
		srand((double)microtime()*1000000);

		for($i=0; $i < $nbChar; $i++) {
			$randString .= $chars[rand()%strlen($chars)];
		}

		return $randString;
	}

	public function generateData() {

		$testingUser = $this->pdo->query("SELECT COUNT(*) AS userscount FROM users");
		$testUser = $testingUser->fetch();

		$testingPost = $this->pdo->query("SELECT COUNT(*) AS postcount FROM publications");
		$testPost = $testingPost->fetch();

		if ($testUser['userscount'] != 0) {

			echo "Allready filled, ";

		} else {

			foreach ($this->names as $username) {

				$salt = self::randomSalt(10);
				$passwordHash = hash('sha256', "123").$salt;

				if ($username == "Admin") {

					$role = 1;

				} else {

					$role = 0;

				}

				$this->pdo->query("INSERT INTO users VALUES (
					NULL,
					'".$role."',
					'".$username."',
					'bidon@mail.com',
					'Machin',
					'Truc',
					'Machin Truc',
					'".$username."' ,
					'',
					'',
					'".$passwordHash."',
					'".$salt."',
					'1423317191',
					''
				)");

				$userId = -1;
				$rows = $this->pdo->prepare("SELECT id FROM users WHERE username=?");
				$rows->execute(array($username));
				$userId = $rows->fetch()['id'];
				$publitoken = self::randomSalt(10);

				if($userId != -1) {
					for ($i=0; $i < 3; $i++) { 
						$this->pdo->query("INSERT INTO publications VALUES (
							NULL,
							'".$userId."',
							'Ceci est un exemple de publication',
							'',
							'',
							'',
							'1423305880',
							'".$publitoken."'
						)");
					}


					foreach ($this->images as $imagetoken) {
						$this->pdo->query("INSERT INTO publications VALUES (
							NULL,
							'".$userId."',
							'Ceci est un exemple imagé',
							'jpg',
							'image',
							'image/jpeg',
							'1423305880',
							'".$imagetoken."'
						)");
					}
				}
			}
		}
	}
}


function fillIt() {
	$lawl = new DatabaseFiller();

	$lawl->connect();
	$lawl->createDatabase();
	$lawl->connectToDatabase();
	$lawl->createTables();
	$lawl->generateData();
}

fillIt();
echo "My job is done !";

?>
