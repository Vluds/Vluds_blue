<?php
define('WEBROOT', str_replace('database-filler.php', '', $_SERVER['SCRIPT_NAME']), true);

class DatabaseFiller {

	private $pdo = null;
	private $dbHost = '127.0.0.1';
	private $dbUser = 'root';
	private $dbPass = '';
	private $dbName = 'vluds_bdd';

	private $names = array('Admin', 'Membre');
	private $images = array('10dcfeh2he', 'xhg56yp3ky');


	public function connectToDatabase() {
		$this->pdo = new PDO('mysql:host='.$this->dbHost.';dbname='.$this->dbName, $this->dbUser, $this->dbPass);
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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


function fillIt() {
	$lawl = new DatabaseFiller();

	$lawl->connectToDatabase();
	$lawl->generateData();
}

fillIt();
echo "my job is done !";

?>
