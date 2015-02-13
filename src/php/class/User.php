<?php
	class User
	{
		public $newbdd;

		private $id;
		private $username;
		private $password;
		private $token;

		public function __construct()
		{
			$this->newbdd = new BDD();
		}

		public static function isLogged()
		{
			if(isset($_SESSION["SID_ID"]) AND !empty($_SESSION["SID_ID"]))
			{		
				return true;	
			}
			else
			{
				return false;
			}
		}

		public function logUser($username, $password)
		{
			$UserInfo = $this->newbdd->select("id, password, salt", "users", "WHERE username LIKE '".$username."' OR email LIKE '".$username."'");
			$isReg = $this->newbdd->num_rows($UserInfo);

			$return = array();

			if($isReg == 1)
			{
				$getUserInfo = $this->newbdd->fetch_array($UserInfo);

				$salt = $getUserInfo['salt'];

				$password = $this->newbdd->real_escape_string(htmlspecialchars($password));
				$passwordHash = hash('sha256', $password).$salt;

				if($passwordHash == $getUserInfo["password"])
				{
					$this->id = $getUserInfo['id'];

					$_SESSION['SID_ID'] = session_id();
					self::setToken($this->id);

					$return["result"] = 1;
					$return["userId"] = $this->id;

					//echo "Connected !";
				}
				else
				{
					//echo "Password faux !";
					$return["result"] = -1;
				}
			}
			else
			{
				//echo "Utilisateur inexistant !";
				$return["result"] = -2;
			}

			return $return;
		}

		public function regUser($username, $password, $email)
		{
			$username = $this->newbdd->real_escape_string(htmlspecialchars($username));
			$username = preg_replace('#[^A-Za-z0-9]+#', '_', $username);
			$username = trim($username, '_');

			$email = $this->newbdd->real_escape_string(htmlspecialchars($email));

			$Email = $this->newbdd->select("id", "users", "WHERE email LIKE '".$email."'");
			$getEmail = $this->newbdd->num_rows($Email);

			if($getEmail != 1)
			{	
				$User = $this->newbdd->select("id", "users", "WHERE username LIKE '".$username."'");
				$getUser = $this->newbdd->num_rows($User);

				if($getUser != 1)
				{	
					$salt = self::randomSalt(10);

					$password = $this->newbdd->real_escape_string(htmlspecialchars($password));
					$passwordHash = hash('sha256', $password).$salt;

					$regUser = $this->newbdd->insert("users", "username, password, salt, email", "'".$username."', '".$passwordHash."', '".$salt."', '".$email."'");

					$UserId = $this->newbdd->select("id", "users", "WHERE password LIKE '".$passwordHash."'");
					$getUserId = $this->newbdd->fetch_array($UserId);

					mkdir(ROOT."users/".$getUserId['id']."/avatar", 0700, true);
					mkdir(ROOT."users/".$getUserId['id']."/banner", 0700, true);

					self::logUser($username, $password);

					return 1;
				}
				else
				{
					return -1;
				}
			}
			else
			{
				return -2;
			}
		}

		public static function logOut()
		{
			$_COOKIE = array();
			$_SESSION = array();

			return true;
		}

		public static function addNotification($userId, $url, $content)
		{
			$newStaticBdd = new BDD();

			$content = $newStaticBdd->real_escape_string(htmlspecialchars($content));

			$notificationToken = self::randomSalt(10);

			$addNotification = $newStaticBdd->insert("notifications", "user_id, url, content, time, token", "'".$userId."', '".$url."', '".$content."', '".time()."', '".$notificationToken."'");
		}

		public static function setFullName($fullname)
		{
			$newStaticBdd = new BDD();

			$fullname = $newStaticBdd->real_escape_string(htmlspecialchars($fullname));

			$newStaticBdd->update("users", "fullname = '".$fullname."'", "WHERE token = '".self::getToken()."'");

			return true;
		}

		public static function randomSalt($nbChar) 
		{
			$randString = "";
			$chars = "abcdefghijklmnpqrstuvwxy0123456789";
			srand((double)microtime()*1000000);
			for($i=0; $i < $nbChar; $i++) 
			{
				$randString .= $chars[rand()%strlen($chars)];
			}

			return $randString;
		}

		public static function setTime()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$newStaticBdd->update("users", "time = '".time()."'", "WHERE id = '".self::getId()."'");

				return true;
			}
			else
			{
				return false;
			}
		}

		public static function setToken($userId)
		{
			$newStaticBdd = new BDD();

			$newStaticBdd->real_escape_string(htmlspecialchars($userId));

			$token = md5(uniqid(mt_rand(), true));

			unset($_COOKIE['token']);

			setcookie("token", $token);

			$newStaticBdd->update("users", "token = '".$token."', time = '".time()."'", "WHERE id = '".$userId."'");


			return true;
		}

		public static function checkToken()
		{
			$return = array();

			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$UserInfo = $newStaticBdd->select("token", "users", "WHERE id LIKE '".self::getId()."'");
				$getUserInfo = $newStaticBdd->fetch_array($UserInfo);

				if(self::getToken() == $getUserInfo['token'])
				{
					return 1;
				}
				else
				{
					return 0;
				}
			}
			else
			{
				return -1;
			}
		}

		public static function getToken()
		{
			if(isset($_COOKIE['token']) AND !empty($_COOKIE['token']))
			{
				return $_COOKIE["token"];
			}
			else
			{
				return "null";
			}
		}

		public function isUserConnectedToBdd()
		{
			$state = $this->newbdd->is_bdd_connected();
			echo $state;
		}

		public static function getId()
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("id", "users", "WHERE token LIKE '".self::getToken()."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['id'];
		}

		public static function getAvatar()
		{
			$newStaticBdd = new BDD();
			$IdToken = $newStaticBdd->select("avatar", "users", "WHERE token LIKE '".self::getToken()."'");
			$getIdToken = $newStaticBdd->fetch_array($IdToken);

			return $getIdToken['avatar'];
		}

		public static function getUsername()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$UsernameToken = $newStaticBdd->select("username", "users", "WHERE token LIKE '".self::getToken()."'");
				$getUsernameToken = $newStaticBdd->fetch_array($UsernameToken);

				return $getUsernameToken['username'];
			}
		}

		//USERROLE
		public static function getUserRole()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$RoleToken = $newStaticBdd->select("role", "users", "WHERE token LIKE '".self::getToken()."'");
				$getRoleToken = $newStaticBdd->fetch_array($RoleToken);

				return $getRoleToken['role'];
			}
		}

		public static function changeUserRole($userId)
		{
			if(self::isLogged())
			{
				if(User::getUserrole() == 1)
				{
					if(isset($userId))
					{
						$newStaticBdd = new BDD();

						$userInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$userId."'");
						$getUserInfos = $newStaticBdd->fetch_array($userInfos);

						if ($getUserInfos['role'] == 1) {
							$newStaticBdd->update("users", "role = '0'", "WHERE id LIKE '".$userId."'");
						} elseif ($getUserInfos['role'] == 0) {
							$newStaticBdd->update("users", "role = '1'", "WHERE id LIKE '".$userId."'");
						}

						$UserRole = $newStaticBdd->select("role", "users", "WHERE id LIKE '".$userId."'");
						$getUserRole = $newStaticBdd->fetch_array($UserRole);

						$dataArray['result'] = true;
						$dataArray['returnRole'] = $getUserRole['role'];
						$dataArray['error'] = null;
					}
					else
					{
						$dataArray['result'] = false;
						$dataArray['error'] = "ID utilisateur non indiqué";
					}
				}
				else
				{
					$dataArray['result'] = false;
					$dataArray['error'] = "Droits insuffisant";
				}
			}
			else
			{
				$dataArray['result'] = false;
				$dataArray['error'] = "Utilisateur non-connecté";
			}

			return $dataArray;
		}


		public static function getFullName()
		{
			if(self::isLogged())
			{
				$newStaticBdd = new BDD();
				$FullName = $newStaticBdd->select("fullname", "users", "WHERE token LIKE '".self::getToken()."'");
				$getFullName = $newStaticBdd->fetch_array($FullName);

				return $getFullName['fullname'];
			}
		}

		public static function loadNotifications()
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$Notifications = $newStaticBdd->select("*", "notifications", "WHERE user_id LIKE '".self::getId()."' ORDER BY time DESC");
			$NotificationsExist = $newStaticBdd->num_rows($Notifications);

			if($NotificationsExist > 0)
			{
				while($getNotifications = $newStaticBdd->fetch_array($Notifications))
				{
					$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getNotifications['user_id']."'");
					$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

					ob_start();
					include('../../models/notification.php');
					$dataArray['reply'] .= ob_get_contents();
					ob_end_clean();
				}

				$dataArray['result'] = true;
			}
			else
			{
				$dataArray['result'] = false;
			}

			return $dataArray;
		}

		public static function readNotification($notificationId)
		{
			if(self::isLogged())
			{
				if(isset($notificationId) AND !empty($notificationId))
				{		
					$newStaticBdd = new BDD();
					$newStaticBdd->update("notifications", "read = '1'", "WHERE id LIKE '".$notificationId."'");

					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function postComment($publicationId, $content)
		{
			$returnComment = array();
			$returnComment['return'] = "";
			$returnComment['content'] = "";

			if(self::isLogged())
			{
				if(isset($content) AND !empty($content))
				{	
					$newStaticBdd = new BDD();
					$content = $newStaticBdd->real_escape_string(htmlspecialchars($content));

					$commentToken = self::randomSalt(10);
					
					$addArtwork = $newStaticBdd->insert("comments", "user_id, publication_id, content, token, time", "'".User::getId()."', '".$publicationId."', '".$content."', '".$commentToken."', '".time()."'");
					
					$Comment = $newStaticBdd->select("*", "comments", "WHERE token LIKE '".$commentToken."'");
					$getComments = $newStaticBdd->fetch_array($Comment);
					
					$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getComments['user_id']."'");
					$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

					ob_start();
					include('../../models/comment.php');
					$returnComment['content'] .= ob_get_contents();
					ob_end_clean();

					$Publication = $newStaticBdd->select("*", "publications", "WHERE id LIKE '".$publicationId."'");
					$getPublication = $newStaticBdd->fetch_array($Publication);

					if($getPublication['user_id'] != User::getId())
					{
						self::addNotification($getPublication['user_id'], "\/publication\/".$getPublication['id'], self::getUsername()." à commenté votre publication");
					}

					$returnComment['return'] = true;
				}
				else
				{
					$returnComment['return'] = false;
				}
			}
			else
			{
				$returnComment['return'] = false;
			}

			return $returnComment;
		}

		public static function deleteComment($commentId)
		{
			if(self::isLogged())
			{
				if(isset($commentId) AND !empty($commentId))
				{		
					$newStaticBdd = new BDD();
					$newStaticBdd->delete("comments", "id LIKE '".$commentId."' AND user_id LIKE '".self::getId()."'");

					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function likePublication($publicationId)
		{
			if(self::isLogged())
			{
				if(isset($publicationId) AND !empty($publicationId))
				{		
					$newStaticBdd = new BDD();
					$newStaticBdd->insert("likes", "user_id, publication_id", "'".User::getId()."', '".$publicationId."'");

					$Publication = $newStaticBdd->select("*", "publications", "WHERE id LIKE '".$publicationId."'");
					$getPublication = $newStaticBdd->fetch_array($Publication);

					if($getPublication['user_id'] != User::getId())
					{
						self::addNotification($getPublication['user_id'], "\/publication\/".$getPublication['id'], self::getUsername()." à aimé votre publication");
					}

					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function unlikePublication($publicationId)
		{
			if(self::isLogged())
			{
				if(isset($publicationId) AND !empty($publicationId))
				{		
					$newStaticBdd = new BDD();
					$addArtwork = $newStaticBdd->delete("likes", "user_id LIKE '".User::getId()."' AND publication_id LIKE '".$publicationId."'");
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function isLiked($userId, $publicationId)
		{
			if(isset($userId) AND !empty($userId) AND isset($publicationId) AND !empty($publicationId))
			{		
				$newStaticBdd = new BDD();
				$Liked = $newStaticBdd->select("*", "likes", "WHERE user_id LIKE '".$userId."' AND publication_id LIKE '".$publicationId."'");
				$isLiked = $newStaticBdd->num_rows($Liked);

				if($isLiked == 1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function addUserTag($name)
		{
			if(self::isLogged())
			{
				if(isset($name) AND !empty($name))
				{		
					$returnUserTags = array();
					$returnUserTags['content'] = "";

					$newStaticBdd = new BDD();

					$name = $newStaticBdd->real_escape_string(htmlspecialchars($name));

					$userTagToken = self::randomSalt(10);

					$newStaticBdd->insert("user_tags", "user_id, name, token", "'".User::getId()."', '".$name."', '".$userTagToken."'");

					$UserTag = $newStaticBdd->select("*", "user_tags", "WHERE token LIKE '".$userTagToken."'");
					$getUserTag = $newStaticBdd->fetch_array($UserTag);

					ob_start();
					include('../../models/user_tag.php');
					$returnUserTags['content'] .= ob_get_contents();
					ob_end_clean();

					$returnUserTags['reply'] = true;
				}
				else
				{
					$returnUserTags['reply'] = false;
				}
			}
			else
			{
				$returnUserTags['reply'] = false;
			}

			return $returnUserTags;
		}

		public static function removeUserTag($tagId)
		{
			if(self::isLogged())
			{
				if(isset($tagId) AND !empty($tagId))
				{		
					$newStaticBdd = new BDD();
					$newStaticBdd->delete("user_tags", "id LIKE '".$tagId."' AND user_id LIKE '".self::getId()."'");

					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function followUser($userId)
		{
			if(self::isLogged())
			{
				if(isset($userId) AND !empty($userId))
				{		
					$newStaticBdd = new BDD();
					$newStaticBdd->insert("followers", "user_id, follower_id", "'".User::getId()."', '".$userId."'");

					self::addNotification($userId, "/".Engine::getUsernameById(User::getId()), self::getUsername()." vous a suivi");

					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function unfollowUser($userId)
		{
			if(self::isLogged())
			{
				if(isset($userId) AND !empty($userId))
				{		
					$newStaticBdd = new BDD();
					$newStaticBdd->delete("followers", "user_id LIKE '".User::getId()."' AND follower_id LIKE '".$userId."'");
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function isFollowed($userId, $followerId)
		{
			if(isset($userId) AND !empty($userId) AND isset($followerId) AND !empty($followerId))
			{		
				$newStaticBdd = new BDD();
				$Followed = $newStaticBdd->select("*", "followers", "WHERE user_id LIKE '".$userId."' AND follower_id LIKE '".$followerId."'");
				$isFollowed = $newStaticBdd->num_rows($Followed);

				if($isFollowed == 1)
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function uploadAvatar($avatarFile)
		{
			if(self::isLogged())
			{
				if(isset($avatarFile) AND !empty($avatarFile)) 
				{
					$newStaticBdd = new BDD();

					$avatarId = self::randomSalt(8);

					$AvatarId = $newStaticBdd->update("users", "avatar = '".$avatarId."'", "WHERE token LIKE '".self::getToken()."'");

					$infoFile = pathinfo($avatarFile['name']);
					$extension_upload = $infoFile['extension'];

					$avatarFileSource = $avatarFile['tmp_name'];

					$ifRotated = 0;

					if($extension_upload == "JPG" OR $extension_upload == "JPEG" OR $extension_upload == "jpg" OR $extension_upload == "jpeg")
					{
						$cover = imagecreatefromjpeg($avatarFileSource);

						$exif = exif_read_data($avatarFileSource);
						if(!empty($exif['Orientation'])) 
						{
							switch($exif['Orientation']) 
							{
							    case 8:
							        $cover = imagerotate($cover, 90, 0);
							        $ifRotated = 1;
							        break;
							    case 3:
							        $cover = imagerotate($cover, 180, 0);
							        $ifRotated = 1;
							        break;
							    case 6:
							        $cover = imagerotate($cover, -90, 0);
							        $ifRotated = 1;
							        break;
							}
						}
					}
					else if($extension_upload == "GIF" OR $extension_upload == "gif")
					{
						$cover = imagecreatefromgif($avatarFileSource);
					}
					else if($extension_upload == "PNG" OR $extension_upload == "png")
					{
						$cover = imagecreatefrompng($avatarFileSource);
					}

					list($coverWidth, $coverHeight) = getimagesize($avatarFileSource);

					if($ifRotated == 1)
					{
						$coverHeightRev = $coverWidth;
						$coverWidthRev = $coverHeight;

						$coverWidth = $coverWidthRev;
						$coverHeight = $coverHeightRev;
					}

					if($coverWidth > $coverHeight)
					{
						$ratio = 60 / $coverWidth;
						$height = $coverHeight * $ratio;

						$avatarResized = imagecreatetruecolor(60, $height);
						imagecopyresampled($avatarResized, $cover, 0, 0, 0, 0, 60, $height, $coverWidth, $coverHeight);
						$cover60 = $avatarResized;

						$ratio = 300 / $coverWidth;
						$height = $coverHeight * $ratio;

						$avatarResized = imagecreatetruecolor(300, $height);
						imagecopyresampled($avatarResized, $cover, 0, 0, 0, 0, 300, $height, $coverWidth, $coverHeight);
						$cover300 = $avatarResized;
					}
					else
					{
						$ratio = 60 / $coverHeight;
						$width = $coverWidth * $ratio;

						$avatarResized = imagecreatetruecolor($width, 60);
						imagecopyresampled($avatarResized, $cover, 0, 0, 0, 0, $width, 60, $coverWidth, $coverHeight);
						$cover60 = $avatarResized;

						$ratio = 300 / $coverHeight;
						$width = $coverWidth * $ratio;

						$avatarResized = imagecreatetruecolor($width, 300);
						imagecopyresampled($avatarResized, $cover, 0, 0, 0, 0, $width, 300, $coverWidth, $coverHeight);
						$cover300 = $avatarResized;
					}
	
					imagepng($cover60, ROOT."users/".User::getId()."/avatar/60_".$avatarId.".png");
					imagepng($cover300, ROOT."users/".User::getId()."/avatar/300_".$avatarId.".png");

					return "users/".User::getId()."/avatar/300_".$avatarId.".png";
				}
				else
				{
					return false;
				}
			}
		}

		public static function uploadBanner($bannerFile)
		{
			if(self::isLogged())
			{
				if(isset($bannerFile) AND !empty($bannerFile)) 
				{
					$newStaticBdd = new BDD();

					$bannerId = self::randomSalt(8);

					$BannerId = $newStaticBdd->update("users", "banner = '".$bannerId."'", "WHERE token LIKE '".self::getToken()."'");

					$infoFile = pathinfo($bannerFile['name']);
					$extension_upload = $infoFile['extension'];

					$bannerFileSource = $bannerFile['tmp_name'];

					$ifRotated = 0;

					if($extension_upload == "JPG" OR $extension_upload == "JPEG" OR $extension_upload == "jpg" OR $extension_upload == "jpeg")
					{
						$banner = imagecreatefromjpeg($bannerFileSource);

						$exif = exif_read_data($bannerFileSource);
						if(!empty($exif['Orientation'])) 
						{
							switch($exif['Orientation']) 
							{
							    case 8:
							        $banner = imagerotate($banner, 90, 0);
							        $ifRotated = 1;
							        break;
							    case 3:
							        $banner = imagerotate($banner, 180, 0);
							        $ifRotated = 1;
							        break;
							    case 6:
							        $banner = imagerotate($banner, -90, 0);
							        $ifRotated = 1;
							        break;
							}
						}
					}
					else if($extension_upload == "GIF" OR $extension_upload == "gif")
					{
						$banner = imagecreatefromgif($bannerFileSource);
					}
					else if($extension_upload == "PNG" OR $extension_upload == "png")
					{
						$banner = imagecreatefrompng($bannerFileSource);
					}

					list($coverWidth, $coverHeight) = getimagesize($bannerFileSource);

					if($ifRotated == 1)
					{
						$coverHeightRev = $coverWidth;
						$coverWidthRev = $coverHeight;

						$coverWidth = $coverWidthRev;
						$coverHeight = $coverHeightRev;
					}

					if($coverWidth > $coverHeight)
					{
						$ratio = 800 / $coverWidth;
						$height = $coverHeight * $ratio;

						$bannerResized = imagecreatetruecolor(800, $height);
						imagecopyresampled($bannerResized, $banner, 0, 0, 0, 0, 800, $height, $coverWidth, $coverHeight);
						$cover300 = $bannerResized;
					}
					else
					{

						$ratio = 800 / $coverHeight;
						$width = $coverWidth * $ratio;

						$bannerResized = imagecreatetruecolor($width, 800);
						imagecopyresampled($bannerResized, $banner, 0, 0, 0, 0, $width, 800, $coverWidth, $coverHeight);
						$cover300 = $bannerResized;
					}
	
					imagepng($cover300, "../../users/".User::getId()."/banner/800_".$bannerId.".png");

					return "users/".User::getId()."/banner/800_".$bannerId.".png";
				}
				else
				{
					return false;
				}
			}
		}

		public static function postPublication($publicationFile, $publicationContent, $publicationTags)
		{
			if(self::isLogged())
			{
				$return = array();

				$newStaticBdd = new BDD();

				$publicationContent = $newStaticBdd->real_escape_string(htmlspecialchars($publicationContent));

				///AddPublication
				$artworkToken = self::randomSalt(10);

				$addArtwork = $newStaticBdd->insert("publications", "user_id, content, token, time", "'".self::getId()."', '".$publicationContent."', '".$artworkToken."', '".time()."'");

				$ArtworkId = $newStaticBdd->select("id, token", "publications", "WHERE token LIKE '".$artworkToken."'");
				$getArtworkId = $newStaticBdd->fetch_array($ArtworkId);

				///AddTags
				$publicationTags = $newStaticBdd->real_escape_string(htmlspecialchars($publicationTags));
				$publicationTags = explode(" ", $publicationTags);

				$result = count($publicationTags);
				$tagsCount = 0;
				while($tagsCount != $result)
				{
					$addArtwork = $newStaticBdd->insert("tags", "publication_id, name", "'".$getArtworkId['id']."', '".$publicationTags[$tagsCount]."'");
					$tagsCount++;
				}

				if(isset($publicationFile) AND !empty($publicationFile)) 
				{	
					///AddCover
					mkdir("../../publications/".$getArtworkId['id'], 0700, true);

					if(isset($coverFile) AND !empty($coverFile)) 
					{
						$infoCover = pathinfo($coverFile['name']);
						$extension_upload = $infoCover['extension'];

						$coverFileSource = $coverFile['tmp_name'];
					}
					else
					{
						$infoCover = pathinfo($publicationFile['name']);
						$extension_upload = $infoCover['extension'];

						$coverFileSource = $publicationFile['tmp_name'];
					}

					$fileType = mime_content_type($publicationFile['tmp_name']);

					if($fileType == 'audio/mpeg' || $fileType == 'audio/mp3' || $fileType == 'audio/x-ms-wma' || $fileType == 'audio/x-wav')
					{
						$infoFile = pathinfo($publicationFile['name']);
						$extension_artworkFile = $infoFile['extension'];

						move_uploaded_file($publicationFile['tmp_name'], "../../publications/".$getArtworkId['id']."/".$artworkToken.".".$extension_artworkFile);

						$updateExtension = $newStaticBdd->update("publications", "ext = '".$extension_artworkFile."'", "WHERE token LIKE '".$getArtworkId['token']."'");
						$updateType = $newStaticBdd->update("publications", "type = 'audio', MIME = '".$fileType."'", "WHERE token LIKE '".$getArtworkId['token']."'");

					}
					else if($fileType == 'video/mp4')
					{
						$infoFile = pathinfo($publicationFile['name']);
						$extension_artworkFile = $infoFile['extension'];

						move_uploaded_file($publicationFile['tmp_name'], "../../publications/".$getArtworkId['id']."/".$artworkToken.".".$extension_artworkFile);

						$updateExtension = $newStaticBdd->update("publications", "ext = '".$extension_artworkFile."'", "WHERE token LIKE '".$getArtworkId['token']."'");
						$updateType = $newStaticBdd->update("publications", "type = 'video', MIME = '".$fileType."'", "WHERE token LIKE '".$getArtworkId['token']."'");
					}
					else if($fileType == 'image/jpeg' || $fileType == 'image/jpg' || $fileType == 'image/gif' || $fileType == 'image/png')
					{
						if($extension_upload == "JPG" OR $extension_upload == "JPEG" OR $extension_upload == "jpg" OR $extension_upload == "jpeg")
						{
							$cover = imagecreatefromjpeg($coverFileSource);

							$ifRotated = 0;

							$exif = exif_read_data($coverFileSource);
							if(!empty($exif['Orientation'])) 
							{
								switch($exif['Orientation']) 
								{
								    case 8:
								        $cover = imagerotate($cover, 90, 0);
								        $ifRotated = 1;
								        break;
								    case 3:
								        $cover = imagerotate($cover, 180, 0);
								        $ifRotated = 1;
								        break;
								    case 6:
								        $cover = imagerotate($cover, -90, 0);
								        $ifRotated = 1;
								        break;
								}
							}

							if($ifRotated == 1)
							{
								$coverHeightRev = $coverWidth;
								$coverWidthRev = $coverHeight;

								$coverWidth = $coverWidthRev;
								$coverHeight = $coverHeightRev;
							}
						}
						else if($extension_upload == "GIF" OR $extension_upload == "gif")
						{
							$cover = imagecreatefromgif($coverFileSource);
						}
						else if($extension_upload == "PNG" OR $extension_upload == "png")
						{
							$cover = imagecreatefrompng($coverFileSource);
						}

						list($coverWidth, $coverHeight) = getimagesize($coverFileSource);

						if($coverWidth > $coverHeight)
						{
							$ratioBlured = 300 / $coverWidth;
							$heightBlured = $coverHeight * $ratioBlured;

							$coverBlured = imagecreatetruecolor(300, $heightBlured);
							imagecopyresampled($coverBlured, $cover, 0, 0, 0, 0, 300, $heightBlured, $coverWidth, $coverHeight);

							if($coverWidth > 800)
							{
								$ratio = 800 / $coverWidth;
								$height = $coverHeight * $ratio;

								$coverResized = imagecreatetruecolor(800, $height);
								imagecopyresampled($coverResized, $cover, 0, 0, 0, 0, 800, $height, $coverWidth, $coverHeight);
								$cover = $coverResized;
							}
						}
						else
						{
							$ratioBlured = 300 / $coverHeight;
							$widthBlured = $coverWidth * $ratioBlured;

							$coverBlured = imagecreatetruecolor($widthBlured, 300);
							imagecopyresampled($coverBlured, $cover, 0, 0, 0, 0, $widthBlured, 300, $coverWidth, $coverHeight);

							if($coverHeight > 800)
							{
								$ratio = 600 / $coverHeight;
								$width = $coverWidth * $ratio;

								$coverResized = imagecreatetruecolor($width, 600);
								imagecopyresampled($coverResized, $cover, 0, 0, 0, 0, $width, 600, $coverWidth, $coverHeight);
								$cover = $coverResized;
							}
						}
		
						imagepng($cover, "../../publications/".$getArtworkId['id']."/cover_".$artworkToken.".png");

						Engine::blurImage($coverBlured, 100);

						imagepng($coverBlured, "../../publications/".$getArtworkId['id']."/coverBlured_".$artworkToken.".png");

						$infoFile = pathinfo($publicationFile['name']);
						$extension_artworkFile = $infoFile['extension'];
						move_uploaded_file($publicationFile['tmp_name'], "../../publications/".$getArtworkId['id']."/".$artworkToken.".".$extension_artworkFile);

						$updateExtension = $newStaticBdd->update("publications", "ext = '".$extension_artworkFile."'", "WHERE token LIKE '".$getArtworkId['token']."'");
						$updateType = $newStaticBdd->update("publications", "type = 'image', MIME = '".$fileType."'", "WHERE token LIKE '".$getArtworkId['token']."'");

					}
				}

				$return['id'] = $getArtworkId['id'];
				$return['result'] = true;

				return $return;
			}
		}

		public static function deleteDirectory($directory, $empty) {

			if(substr($directory,-1) == "/") {
				$directory = substr($directory,0,-1);
			}

			if(!file_exists($directory) || !is_dir($directory)) {
				return false;
			} elseif(!is_readable($directory)) {
				return false;
			} else {
				$directoryHandle = opendir($directory);
		
		        while ($contents = readdir($directoryHandle)) {
		            if($contents != '.' && $contents != '..') {
		                $path = $directory . "/" . $contents;
		 
		                if(is_dir($path)) {
		                    supprimer_dossier($path);
		                } else {
		                    unlink($path);
		                }
		            }
		        }
		 
		        closedir($directoryHandle);
		 
		        if($empty == false) {
		            if(!rmdir($directory)) {
		                return false;
		            }
		        }
		 
		        return true;
		    }
		} 

		public static function deletePublication($publicationId)
		{
			if(self::isLogged())
			{
				if(isset($publicationId))
				{		
					$newStaticBdd = new BDD();

					$publicationInfos = $newStaticBdd->select("*", "publications", "WHERE id LIKE '".$publicationId."'");
					$getpublicationInfos = $newStaticBdd->fetch_array($publicationInfos);

					if($getpublicationInfos['user_id'] == User::getId() OR User::getUserrole() == 1)
					{
						$newStaticBdd->delete("publications", "id LIKE '".$publicationId."'");
						self::deleteDirectory(ROOT.'publications/'.$publicationId, false);
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

		public static function deleteUser($userId)
		{
			if(self::isLogged())
			{
				if(User::getUserrole() == 1)
				{
					if(isset($userId))
					{
						$newStaticBdd = new BDD();

						$userInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$userId."'");
						$getuserInfos = $newStaticBdd->fetch_array($userInfos);

						$newStaticBdd->delete("users", "id LIKE '".$userId."'");

						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}

	}
?>