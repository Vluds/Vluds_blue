<?php

	class Engine
	{
		public $newbdd;

		public function __construct()
		{
			$this->newbdd = new BDD();
		}

		public static function ellapsedTime($time)
		{
			$now = time();

			$ellapsedValues = array (
		        31536000 => 'year',
		        2592000 => 'month',
		        604800 => 'week',
		        86400 => 'day',
		        3600 => 'hour',
		        60 => 'minute',
		        1 => 'second'
		    );

		    $ellapsedTime = $now - $time;

		    $count = $ellapsedTime / 1;
		   	$count = round($count, 0);

		   	if($count < 10)
		   	{
		   		return "A l'instant";
		   	}
		   	else if($count >= 10 & $count < 60)
		    {
		    	return $count." s";
		    }
		    else if($count >= 60 & $count < 3600)
		    {
		    	$count = $ellapsedTime / 60;
		   		$count = round($count, 0);

		    	return $count." min";
		    }
		    else if($count >= 60 & $count < 86400)
		    {
		    	$count = $ellapsedTime / 3600;
		   		$count = round($count, 0);

		    	return $count." h";
		    }
		    else if($count >= 86400 & $count < 604800)
		    {
		    	$count = $ellapsedTime / 86400;
		   		$count = round($count, 0);

		    	return $count." j";
		    }
		    else if($count >= 604800 & $count < 2592000)
		    {
		    	$count = $ellapsedTime / 604800;
		   		$count = round($count, 0);

		    	return $count." sem";
		    }
		    else if($count >= 2592000 & $count < 31536000)
		    {
		    	$count = $ellapsedTime / 2592000;
		   		$count = round($count, 0);

		    	return $count." mois";
		    }
		    else if($count >= 31536000)
		    {
		    	$count = $ellapsedTime / 31536000;
		   		$count = round($count, 0);

		    	return $count." an";
		    }
		}

		public static function blurImage($coverBlured, $do)
		{
			$count = 0;
			while($count != $do)
			{
				imagefilter($coverBlured, IMG_FILTER_GAUSSIAN_BLUR);

				$count++;
			}

			return $coverBlured;
		}

		public static function getUsernameById($id)
		{
			$newStaticBdd = new BDD();
			$Username = $newStaticBdd->select("username", "users", "WHERE id LIKE '".$id."'");
			$getUsername = $newStaticBdd->fetch_array($Username);

			return $getUsername['username'];
		}

		public static function getFirstNameById($id)
		{
			$newStaticBdd = new BDD();
			$FirstName = $newStaticBdd->select("firstname", "users", "WHERE id LIKE '".$id."'");
			$getFirstName = $newStaticBdd->fetch_array($FirstName);

			return $getFirstName['firstname'];
		}

		public static function getLastNameById($id)
		{
			$newStaticBdd = new BDD();
			$LastName = $newStaticBdd->select("lastname", "users", "WHERE id LIKE '".$id."'");
			$getLastName = $newStaticBdd->fetch_array($LastName);

			return $getLastName['lastname'];
		}

		public static function getType($id)
		{
			$newStaticBdd = new BDD();
			$State = $newStaticBdd->select("name", "type", "WHERE type_id LIKE '".$id."'");
			$getState = $newStaticBdd->fetch_array($State);

			return $getState['name'];
		}

		public static function getComments($id, $count)
		{
			$returnComments = array();
			$returnComments['content'] = "";

			$newStaticBdd = new BDD();
			$Comment = $newStaticBdd->select("*", "comments", "WHERE publication_id LIKE '".$id."' ORDER BY id DESC LIMIT 0, ".$count."");

			while($getComments = $newStaticBdd->fetch_array($Comment))
			{
				$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getComments['user_id']."'");
				$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

				ob_start();
				include(ROOT.'models/comment.php');
				$returnComments['content'] .= ob_get_contents();
				ob_end_clean();
			}

			return $returnComments['content'];
		}

		public static function getCommentByToken($token)
		{
			$returnComment = array();
			$returnComment['content'] = "";

			$newStaticBdd = new BDD();
			$Comment = $newStaticBdd->select("*", "comments", "WHERE token LIKE '".$token."'");

			$getComment = $newStaticBdd->fetch_array($Comment);
			
			$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getComment['user_id']."'");
			$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

			ob_start();
			include(ROOT.'models/comment.php');
			$returnComment['content'] .= ob_get_contents();
			ob_end_clean();

			return $returnComment['content'];
		}

		public static function getTags($id, $count)
		{
			$returnTags = array();
			$returnTags['content'] = "";

			$newStaticBdd = new BDD();
			$Tag = $newStaticBdd->select("id, name", "tags", "WHERE publication_id LIKE '".$id."' ORDER BY rand() LIMIT 0, ".$count."");

			while($getTag = $newStaticBdd->fetch_array($Tag))
			{
				ob_start();
				include(ROOT.'models/tag.php');
				$returnTags['content'] .= ob_get_contents();
				ob_end_clean();
			}

			return $returnTags['content'];
		}

		public static function getUserTags($id, $count)
		{
			$returnUserTags = array();
			$returnUserTags['content'] = "";

			$newStaticBdd = new BDD();
			$UserTag = $newStaticBdd->select("*", "user_tags", "WHERE user_id LIKE '".$id."' ORDER BY rand() LIMIT 0, ".$count."");

			while($getUserTag = $newStaticBdd->fetch_array($UserTag))
			{
				ob_start();
				include(ROOT.'models/user_tag.php');
				$returnUserTags['content'] .= ob_get_contents();
				ob_end_clean();
			}

			return $returnUserTags['content'];
		}

		public static function getFlux($limit, $offset)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$publicationCount = 0;

			$Publication = $newStaticBdd->select("*", "publications", "ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset."");

			$nbProfil = rand(1, $limit);

			while($getPublication = $newStaticBdd->fetch_array($Publication))
			{
				$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getPublication['user_id']."'");
				$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

				ob_start();
				include(ROOT.'models/publication.php');
				$dataArray['reply'] .= ob_get_contents();
				ob_end_clean();

				$publicationCount++;

				/////ADD PROFIL PUBLICATION

				if($publicationCount == $nbProfil)
				{
					if(User::isLogged())
					{
						$ProfilInfos = $newStaticBdd->select("*", "users", "WHERE token NOT LIKE '".User::getToken()."' ORDER BY rand() LIMIT 0, 1 ");

						while($getProfilInfos = $newStaticBdd->fetch_array($ProfilInfos))
						{
							if(User::isFollowed(User::getId(), $getProfilInfos['id']) == false)
							{
								ob_start();
								include(ROOT.'models/profil-publication.php');
								$dataArray['reply'] .= ob_get_contents();
								ob_end_clean();
							}
						}
					}
					else
					{
						$ProfilInfos = $newStaticBdd->select("*", "users", "ORDER BY rand() LIMIT 0, 1");

						while($getProfilInfos = $newStaticBdd->fetch_array($ProfilInfos))
						{
							ob_start();
							include(ROOT.'models/profil-publication.php');
							$dataArray['reply'] .= ob_get_contents();
							ob_end_clean();
						}
					}

				}
			}

			return $dataArray['reply'];
		}

		public static function getPublicationsByUserId($userId, $limit, $offset)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$Publication = $newStaticBdd->select("*", "publications", "WHERE user_id LIKE ".$userId." ORDER BY id DESC LIMIT ".$limit." OFFSET ".$offset."");

			while($getPublication = $newStaticBdd->fetch_array($Publication))
			{
				$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getPublication['user_id']."'");
				$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

				ob_start();
				include(ROOT.'models/publication.php');
				$dataArray['reply'] .= ob_get_contents();
				ob_end_clean();
			}

			return $dataArray['reply'];
		}

		public static function getPublicationsById($id)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$Publication = $newStaticBdd->select("*", "publications", "WHERE id LIKE ".$id."");

			$getPublication = $newStaticBdd->fetch_array($Publication);
			
			$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getPublication['user_id']."'");
			$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

			ob_start();
			include(ROOT.'models/publication_view.php');
			$dataArray['reply'] .= ob_get_contents();
			ob_end_clean();

			return $dataArray['reply'];
		}

		public static function loadFile($file)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";
			
			ob_start();
			include(ROOT.'includes/'.$file.'.php');
			$dataArray['reply'] .= ob_get_contents();
			ob_end_clean();

			return $dataArray['reply'];
		}

		public static function loadProfil($username)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$UserInfos = $newStaticBdd->select("*", "users", "WHERE username LIKE '".$username."'");
			$getUserInfos = $newStaticBdd->fetch_array($UserInfos);
			$usernameExist = $newStaticBdd->num_rows($UserInfos);

			if($usernameExist == 1)
			{
				ob_start();
				include(ROOT.'models/profil.php');
				$dataArray['reply'] .= ob_get_contents();
				ob_end_clean();

				return $dataArray['reply'];
			}
			else
			{
				return false;
			}
		}

		public static function loadTagsFinder($tag)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$TagsInfos = $newStaticBdd->select("*", "tags", "WHERE name LIKE '%".$tag."%' ORDER BY id DESC");
			while($getTagsInfos = $newStaticBdd->fetch_array($TagsInfos))
			{
				$Publication = $newStaticBdd->select("*", "publications", "WHERE id LIKE ".$getTagsInfos['publication_id']."");
				$getPublication = $newStaticBdd->fetch_array($Publication);

				$isPublicationExist = $newStaticBdd->num_rows($Publication);

				if($isPublicationExist == 1)
				{
					$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getPublication['user_id']."'");
					$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

					ob_start();
					include(ROOT.'models/publication.php');
					$dataArray['reply'] .= ob_get_contents();
					ob_end_clean();
				}
			}

			$UserTags = $newStaticBdd->select("*", "user_tags", "WHERE name LIKE '%".$tag."%'");
			while($getUserTags = $newStaticBdd->fetch_array($UserTags))
			{
				$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getUserTags['user_id']."'");
				$getProfilInfos = $newStaticBdd->fetch_array($UserInfos);

				$isUserExist = $newStaticBdd->num_rows($UserInfos);

				if($isUserExist == 1)
				{
					ob_start();
					include(ROOT.'models/profil-publication.php');
					$dataArray['reply'] .= ob_get_contents();
					ob_end_clean();
				}
			}

			return $dataArray['reply'];
		}

		public static function loadPublicationViewer($id)
		{
			$newStaticBdd = new BDD();	
			$dataArray['reply'] = "";

			$Publication = $newStaticBdd->select("*", "publications", "WHERE id LIKE '".$id."'");
			$getPublication = $newStaticBdd->fetch_array($Publication);
			$publicationExist = $newStaticBdd->num_rows($Publication);

			if($publicationExist == 1)
			{

				$UserInfos = $newStaticBdd->select("*", "users", "WHERE id LIKE '".$getPublication['user_id']."'");
				$getUserInfos = $newStaticBdd->fetch_array($UserInfos);

				ob_start();
				include(ROOT.'models/publication_view.php');
				$dataArray['reply'] .= ob_get_contents();
				ob_end_clean();

				return $dataArray['reply'];
			}
			else
			{
				return false;
			}
		}

		public static function sendConfirmationMail($email, $username)
		{
			if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $email)) // On filtre les serveurs qui présentent des bogues.
			{
				$newline = "\r\n";
			}
			else
			{
				$newline = "\n";
			}

			//=====Définition du sujet.
			$title = "Bienvenue ".$username." !";
			//=========

			//=====Déclaration des contents au format texte et au format HTML.
			$content_txt = "Vluds - Vous êtes nouveau ? Suivez-moi ...";

			ob_start();
			include(ROOT.'includes/confirmation_email.php');

			$content_html = ob_get_contents();

			ob_end_clean();

			//==========
			 
			//=====Création de la boundary.
			$boundary = "-----=".md5(rand());
			$boundary_alt = "-----=".md5(rand());
			//==========
			 
			//=====Création du header de l'e-mail.
			$header = "From: \"Vluds\"<no-repeat@vluds.eu>".$newline;
			$header.= "Reply-to: \"Vluds\" <no-repeat@vluds.eu>".$newline;
			$header.= "MIME-Version: 1.0".$newline;
			$header.= "Content-Type: multipart/mixed;".$newline." boundary=\"$boundary\"".$newline;
			//==========
			 
			//=====Création du content.
			$content = $newline."--".$boundary.$newline;
			$content.= "Content-Type: multipart/alternative;".$newline." boundary=\"$boundary_alt\"".$newline;
			$content.= $newline."--".$boundary_alt.$newline;
			//=====Ajout du content au format texte.
			$content.= "Content-Type: text/plain; charset=\"utf-8\"".$newline;
			$content.= "Content-Transfer-Encoding: 8bit".$newline;
			$content.= $newline.$content_txt.$newline;
			//==========
			 
			$content.= $newline."--".$boundary_alt.$newline;
			 
			//=====Ajout du content au format HTML.
			$content.= "Content-Type: text/html; charset=\"utf-8\"".$newline;
			$content.= "Content-Transfer-Encoding: 8bit".$newline;
			$content.= $newline.$content_html.$newline;
			//==========
			 
			//=====On ferme la boundary alternative.
			$content.= $newline."--".$boundary_alt."--".$newline;
			//==========
			 
			 
			 
			$content.= $newline."--".$boundary.$newline;
			 
			//=====Envoi de l'e-mail.
			mail($email,$title,$content,$header);
			 
			//==========

			return $dataArray['reply'];
		}
	}
?>