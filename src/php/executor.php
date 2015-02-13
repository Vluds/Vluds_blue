<?php
	session_start();

	// Define directory.
	define('ROOT', str_replace('src/php/executor.php', '', $_SERVER['SCRIPT_FILENAME']), true);
	define('WEBROOT', str_replace('src/php/executor.php', '', $_SERVER['SCRIPT_NAME']), true);

	require("class/bdd.php");
	require("class/User.php");
	require("class/Engine.php");

	$dataArray = array();

	if(isset($_POST['action']) AND !empty($_POST['action']))
	{
		$action = $_POST['action'];

		////////regUser///////
		if($action == "regUser")
		{
			if((isset($_POST['username']) AND !empty($_POST['username'])) AND (isset($_POST['password']) AND !empty($_POST['password'])) AND (isset($_POST['email']) AND !empty($_POST['email'])))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];
				$email = $_POST['email'];

				$newUser = new User();
				if($newUser->regUser($username, $password, $email) == 1)
				{
					$dataArray['result'] = 1;
				}
				else if($newUser->regUser($username, $password, $email) == -1)
				{
					$dataArray['result'] = -1;
				}
				else if($newUser->regUser($username, $password, $email) == -2)
				{
					$dataArray['result'] = -2;
				}
			}
			else
			{
				$dataArray['result'] = -3;
			}

		}

		////////logIn///////
		if($action == "logUser")
		{
			if((isset($_POST['username']) AND !empty($_POST['username'])) AND (isset($_POST['password']) AND !empty($_POST['password'])))
			{
				$username = $_POST['username'];
				$password = $_POST['password'];

				$newUser = new User();

				$returnLog = array();
				$returnLog = $newUser->logUser($username, $password);
				if($returnLog['result'] == 1)
				{
					$dataArray['userId'] = $returnLog['userId'];
					$dataArray['result'] = 1;
				}
				else if($returnLog['result'] == -1)
				{
					$dataArray['result'] = -1;
				}
				else if($returnLog['result'] == -2)
				{
					$dataArray['result'] = -2;
				}
			}
			else
			{
				$dataArray['result'] = -3;
				//echo "Error logins not set !";
			}

		}

		////////logOut///////
		if($action == "logOut")
		{
			if(User::logOut())
			{
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		////////setTime///////
		if($action == "setTime")
		{
			if(User::setTime())
			{
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		////////setFullName///////
		if($action == "setFullName")
		{
			if(isset($_POST['fullname'])) 
			{
				$fullname = $_POST['fullname'];

				if(User::setFullName($fullname))
				{
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
		}

		if($action == "getFlux")
		{
			if(isset($_POST['line']) AND isset($_POST['limit']))
			{
				$line = $_POST['line'];
				$limit = $_POST['limit'];

				$dataArray['reply'] = Engine::getFlux($line, $limit);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
				$dataArray['result'] = 0;
			}
		}

		if($action == "getPublicationsByUserId") 
		{
			if(isset($_POST['userId']) and isset($_POST['limit']) and isset($_POST['offset']))
			{
				$userId = $_POST['userId'];
				$limit = $_POST['limit'];
				$offset = $_POST['offset'];

				$dataArray['reply'] = Engine::getPublicationsByUserId($userId, $limit, $offset);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
				$dataArray['result'] = 0;
			}
		}

		if($action == "postComment") 
		{
			if(isset($_POST['content']) AND isset($_POST['publicationId']))
			{
				$publicationId = $_POST['publicationId'];
				$content = $_POST['content'];

				$returnPost = array();
				$returnPost = User::postComment($publicationId, $content);
				if($returnPost['return'] == true)	
				{
					$dataArray['reply'] = $returnPost['content'];
					$dataArray['result'] = $returnPost['return'];
				}
				else
				{
					$dataArray['result'] = false;
				}
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "deleteComment") 
		{
			if(isset($_POST['commentId']))
			{
				$commentId = $_POST['commentId'];

				if(User::deleteComment($commentId))
				{
					$dataArray['result'] = true;
				}
				else
				{
					$dataArray['result'] = false;
				}
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "likePublication") 
		{
			if(isset($_POST['publicationId']))
			{
				$publicationId = $_POST['publicationId'];

				if(User::likePublication($publicationId))
				{
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "unlikePublication") 
		{
			if(isset($_POST['publicationId']))
			{
				$publicationId = $_POST['publicationId'];

				if(User::unlikePublication($publicationId))
				{
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "addUserTag") 
		{
			if(isset($_POST['name']))
			{
				$name = $_POST['name'];

				$returnPost = array();
				$returnPost = User::addUserTag($name);
				
				if($returnPost['reply'] == true)	
				{
					$dataArray['reply'] = $returnPost['content'];
					$dataArray['result'] = true;
				}
				else
				{
					$dataArray['result'] = false;
				}
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "removeUserTag") 
		{
			if(isset($_POST['tagId']))
			{
				$tagId = $_POST['tagId'];

				if(User::removeUserTag($tagId))
				{
					$dataArray['result'] = true;
				}
				else
				{
					$dataArray['result'] = false;
				}
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "followUser") 
		{
			if(isset($_POST['userId']))
			{
				$userId = $_POST['userId'];

				if(User::followUser($userId))
				{
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "unfollowUser") 
		{
			if(isset($_POST['userId']))
			{
				$userId = $_POST['userId'];

				if(User::unfollowUser($userId))
				{
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}


		if($action == "checkToken") 
		{
			$returnToken = User::checkToken();
			if($returnToken == 1)
			{
				$dataArray['result'] = 1;
			}
			else if ($returnToken == -1)
			{
				$dataArray['result'] = -1;
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "loadFile") 
		{
			if(isset($_POST['file']) and isset($_POST['file']))
			{
				$file = $_POST['file'];

				$dataArray['reply'] = Engine::loadFile($file);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
			}
		}

		if($action == "loadProfil") 
		{
			if(isset($_POST['username']) and isset($_POST['username']))
			{
				$username = $_POST['username'];

				$dataArray['reply'] = Engine::loadProfil($username);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
			}
		}

		if($action == "loadNotifications") 
		{
			$returnNotifications = array();
			$returnNotifications = User::loadNotifications();
			if($returnNotifications['result'])
			{
				$dataArray['reply'] = $returnNotifications['reply'];
				$dataArray['result'] = true;
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "readNotification") 
		{
			if(isset($_POST['notificationId']))
			{
				$notificationId = $_POST['notificationId'];

				if(User::readNotification($notificationId))
				{
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "loadTagsFinder") 
		{
			if(isset($_POST['tag']) and isset($_POST['tag']))
			{
				$tag = $_POST['tag'];

				$dataArray['reply'] = Engine::loadTagsFinder($tag);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
			}
		}

		if($action == "loadPublicationViewer") 
		{
			if(isset($_POST['id']) and isset($_POST['id']))
			{
				$id = $_POST['id'];

				$dataArray['reply'] = Engine::loadPublicationViewer($id);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
			}
		}

		if($action == "loadManager") 
		{
			$dataArray['reply'] = Engine::loadManager();
			$dataArray['result'] = 1;
		}

		if($action == "sendConfirmationMail") 
		{
			if(isset($_POST['email']) and isset($_POST['email']) AND isset($_POST['username']) and isset($_POST['username']))
			{
				$email = $_POST['email'];
				$username = $_POST['username'];

				$dataArray['reply'] = Engine::sendConfirmationMail($email, $username);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['reply'] = 0;
			}
		}

		if($action == "uploadAvatar") 
		{
			if(isset($_FILES['avatarFile']) and !empty($_FILES['avatarFile']))
			{
				$avatarFile = $_FILES['avatarFile'];

				$dataArray['reply'] = User::uploadAvatar($avatarFile);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "uploadBanner") 
		{
			if(isset($_FILES['bannerFile']) and !empty($_FILES['bannerFile']))
			{
				$bannerFile = $_FILES['bannerFile'];

				$dataArray['reply'] = User::uploadBanner($bannerFile);
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}

		if($action == "postPublication") 
		{
			if((isset($_POST['publicationContent']) and !empty($_POST['publicationContent'])) AND (isset($_POST['publicationTags']) and !empty($_POST['publicationTags'])))
			{
				if(isset($_FILES['publicationFile']) AND !empty($_FILES['publicationFile']))
				{
					$publicationFile = $_FILES['publicationFile'];
				}
				else
				{
					$publicationFile = null;
				}

				$publicationContent = $_POST['publicationContent'];
				$publicationTags = $_POST['publicationTags'];

				if(isset($_FILES['coverFile']) and !empty($_FILES['coverFile']))
				{
					$coverFile = $_FILES['coverFile'];
				}
				else
				{
					$coverFile = null;
				}

				$returnLog = array();
				$returnLog = User::postPublication($publicationFile, $publicationContent, $publicationTags);
				
				if($returnLog['result'] == true)
				{
					$dataArray['id'] = $returnLog['id'];
					$dataArray['result'] = 1;
				}
				else
				{
					$dataArray['result'] = 0;
				}
			}
			else
			{
				$dataArray['result'] = -1;
			}
		}

		if($action == "deletePublication")
		{
			if(isset($_POST['publicationId']))
			{
				$publicationId = $_POST['publicationId'];

				if(User::deletePublication($publicationId))
				{
					$dataArray['result'] = true;
				}
				else
				{
					$dataArray['result'] = false;
				}
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "deleteUser")
		{
			if(isset($_POST['userId']))
			{
				$userId = $_POST['userId'];

				if(User::deleteUser($userId))
				{
					$dataArray['result'] = true;
				}
				else
				{
					$dataArray['result'] = false;
				}
			}
			else
			{
				$dataArray['result'] = false;
			}
		}

		if($action == "changeUserRole")
		{
			if(isset($_POST['userId']))
			{
				$userId = $_POST['userId'];

				$returnRole = array();
				$returnRole = User::changeUserRole($userId);

				if($returnRole['result'] == true)
				{
					$dataArray['result'] = true;
					$dataArray['returnRole'] = $returnRole['returnRole'];
				}
				else
				{
					$dataArray['result'] = false;
					$dataArray['returnRole'] = null;
				}
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['returnRole'] = null;
			}
		}

		if($action == "isLogged")
		{
			if(User::isLogged())
			{
				$dataArray['result'] = 1;
			}
			else
			{
				$dataArray['result'] = 0;
			}
		}
	}
	else
	{
		$dataArray['result'] = "error: POST NOT SET";
	}

	echo json_encode($dataArray);
?>