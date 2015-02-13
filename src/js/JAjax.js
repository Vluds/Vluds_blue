var isBusy = 0;

function regUser(email, password, username)
{
	var checkAT = email.indexOf('@');
	var checkDOT = email.indexOf('.');

	if(email != "" & password != "" & username != "")
	{
		if(checkAT > -1 && checkDOT > -1)
		{
			$.post(setJsPath + "src/php/executor.php", { action: "regUser", email: email, password: password, username: username}, function(data)
			{
				if(data.result == 1)
				{
					sendConfirmationMail(email, username);

					logUser(username, password);

					backgroundBox(0);
					regBox(0);

					messageBox("Vous êtes maintenant enregistré !");
				}
				else if(data.result == -3)
				{
					messageBox("Veuillez remplir tout les champs !");
					$('#regBox').wiggle(400);
				}
				else if(data.result == -2)
				{
					messageBox("Cet adresse email est déjà utilisée !");
					$('#regBox').wiggle(400);
				}
				else if(data.result == -1)
				{
					messageBox("Ce nom d'utilisateur est déjà utilisé ");
					$('#regBox').wiggle(400);
				}
				else
				{
					messageBox("Erreur: nous n'avons pas pu vous enregistrer ...");
					$('#regBox').wiggle(400);
				}

			}, "json");
		}
		else
		{
			messageBox("L'adresse e-mail est invalide !");
		}
	}
	else
	{
		messageBox("Veuillez remplir tout les champs !");
		$('#regBox').wiggle(400);
	}
}

function logUser(username, password)
{
	$.post(setJsPath + "src/php/executor.php", { action: "logUser", username: username, password: password}, function(data)
	{
		if(data.result == 1)
		{
			$('#signBox #container input#password').val("");

			loadSideBar();
			loadFile("publicationViewer", 'body');

			delDiv('#postPublication', 200)
			loadFile('postPublication', '#module-container');

			delDiv('#publicationViewer', 200)
			loadFile('publicationViewer', '#module-container');

			getFlux();

			backgroundBox(0);
			signBox(0);
			messageBox("Vous êtes maintenant connecté !");
		}
		else if(data.result == -3)
		{
			$('#signBox').wiggle(400);
			messageBox("Veuillez remplir tout les champs !");
		}
		else if(data.result == -2)
		{
			$('#signBox').wiggle(400);
			messageBox("Le nom d'utilisateur n'existe pas !");
		}
		else if(data.result == -1)
		{
			$('#signBox').wiggle(400);
			messageBox("Le mot de passe est érronné !");
		}

	}, "json");
}

function logOut()
{
	$.post(setJsPath + "src/php/executor.php", { action: "logOut"}, function(data)
	{
		if(data.result == 1)
		{	
			loadSideBar();
			loadFile("publicationViewer", 'body');

			delDiv('#postPublication', 200)
			loadFile('postPublication', '#module-container');

			delDiv('#publicationViewer', 200)
			loadFile('publicationViewer', '#module-container');

			getFlux();

			messageBox("Vous êtes maintenant déconnecté !");
		}
		else
		{
			messageBox("LogOut: Nous n'avons pas pu vous déconnecter !");
		}

	}, "json");
}

function setTime()
{
	$.post(setJsPath + "src/php/executor.php", { action: "setTime"}, function(data)
	{
		if(data.result == 1)
		{
			console.log("time set");
		}
		else
		{
			console.log("time not set");
		}

	}, "json");
}

function setFullName()
{
	var fullname = $('#sidebar #profil #addName #fullname input').val();

	$.post(setJsPath + "src/php/executor.php", { action: "setFullName", fullname: fullname}, function(data)
	{
		if(data.result == 1)
		{
			$('#sidebar #profil #addName #fullname').html("<h3>" + fullname + "</h3>");

			messageBox("Votre nom à bien été enregistré !");
		}
		else
		{
			messageBox("Nous n'avons pas pu enregistrer votre nom ...");
		}

	}, "json");
}

function getFlux()
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$("#include-container").stop().fadeOut(200)
		.queue(function() {
			window.history.pushState({page: 'flux'}, "Flux d'actualité", setJsPath + "Flux");
			document.title = "Vluds - Flux d'actualité";

			$('#include-container').html("");
			$('#include-container').loadingIn();

			loadFile("flux-container", '#include-container');

			var containerHeight = $('#include-container').height();
			var nbLinePerHeight = (containerHeight / 300);
			nbLinePerHeight = Math.round(nbLinePerHeight, 0);
			console.log("Height: " + containerHeight);
			console.log("line: " + nbLinePerHeight);

			var containerWidth = $('#include-container').width();
			var nbPublicationPerWidth = (containerWidth / 510);
			nbPublicationPerWidth = Math.round(nbPublicationPerWidth, 0) + 3;
			console.log("Width: " + containerWidth);
			console.log("per width: " + nbPublicationPerWidth);

			var offset = 0;

			var countLine = 0;

			var margin = 0;

			var publicationContainerHeight = 0;

			var remainingSpace = 0;
			var scrollingBarHeight = 15;

			var existingMargin = 0;

			function ajaxRequest(callback)
			 {
				var formData = new FormData();
				formData.append("action", "getFlux");
				formData.append("line", nbLinePerHeight);
				formData.append("limit", nbPublicationPerWidth);
				formData.append("offset", offset);

				var xhr = new XMLHttpRequest();

				xhr.onreadystatechange = function() 
				{
					if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
					{
						var myArr = JSON.parse(xhr.responseText);
						callback(myArr);
					}
				};

				xhr.open('POST', 'src/php/executor.php', true);
				xhr.send(formData);
			}

			function readData(sData) 
			{
				$('#include-container').loadingOut();

				if(sData.reply == "")
				{
					messageBox("Aucune publication à afficher ...");
				}
				else if(sData.result == 1)
				{
					$('#publication-container').append(sData.reply);

					includeContainerWidth = $('#include-container').width();
					console.log("includeContainerWidth: " + includeContainerWidth);

					$('.publication-line').width(includeContainerWidth * 4);

					publicationContainerHeight = $('.publication-line').height() * nbLinePerHeight;
					console.log("publicationContainerHeight: " + publicationContainerHeight);

					remainingSpace = containerHeight - publicationContainerHeight;
					remainingSpace = remainingSpace - scrollingBarHeight;
					console.log("remainingSpace: " + remainingSpace);

					margin = remainingSpace / nbLinePerHeight;
					margin = margin / 2;
					margin = Math.round(margin, 0) - 1;
					console.log("margin: " + margin);
						
					marginMini = margin / 2;
					marginMini = Math.round(marginMini, 0);
					console.log("marginMini: " + marginMini);

					existingMargin = $(".publication").css("margin");
					console.log("existingMargin: " + existingMargin);
				}
				else
				{
					messageBox("Erreur lors du chargement des publications !");
				}

				$('.publication img').load(function(){
					$('.publication').fadeIn(400);
					$('.publication').animate({ marginTop: '+' + margin + 'px', marginBottom: '+' + margin + 'px', marginLeft: '+' + marginMini + 'px', marginRight: '+' + marginMini + 'px'}, 200);
				});

				isBusy = 0;
			}

			ajaxRequest(readData);

			$(this).dequeue();

		}).fadeIn(100);
	}
	else
	{
		console.log("Ajax occupé");
	}
}

function getPublicationsByUserId(userId)
{
	var containerWidth = $('#include-container').width();
	var nbPublicationPerWidth = (containerWidth / 400);
	nbPublicationPerWidth = Math.round(nbPublicationPerWidth, 0);
	console.log("per width: " + nbPublicationPerWidth);

	var containerHeight = $('#include-container').height();
	var nbLinePerHeight = (containerHeight / 202);
	nbLinePerHeight = Math.round(nbLinePerHeight, 0);
	console.log("line: " + nbLinePerHeight);

	var offset = 0;

	var countLine = 0;

	while(countLine != nbLinePerHeight)
	{
		$.post(setJsPath + "src/php/executor.php", { action: "getPublicationsByUserId", userId: userId, limit: nbPublicationPerWidth, offset: offset }, function(data)
		{
			if(data.result == 1)
			{
				$('#include-container').loadingOut();
				$('#publication-container').append(data.reply);

				$('.publication img').load(function(){
					$('.publication').fadeIn(400);
				});
			}
			else
			{
				messageBox("Erreur lors du chargement des publications du profil !");
			}

		}, "json");

		offset = offset + nbPublicationPerWidth;
		countLine++;
	}
}

function postComment(publicationId, content)
{	
	$.post(setJsPath + "src/php/executor.php", { action: "postComment", publicationId: publicationId, content: content }, function(data)
	{
		if(data.result == true)
		{
			messageBox("Posté !");
			$("#post-comment #textarea-container textarea").val("");
			$('#comments-content').prepend(data.reply);
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function likePublication(publicationId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "likePublication", publicationId: publicationId }, function(data)
	{
		if(data.result == 1)
		{
			messageBox("Like !");
			$('.publication#' + publicationId + " .like").removeClass("unliked").addClass("liked");
			$('.publication#' + publicationId + " .hover").removeClass("unliked").addClass("liked");
			$('.publication#' + publicationId + " .hover").stop().fadeIn(400);
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function unlikePublication(publicationId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "unlikePublication", publicationId: publicationId }, function(data)
	{
		if(data.result == 1)
		{
			messageBox("Unlike !");
			$('.publication#' + publicationId + " .like").removeClass("liked").addClass("unliked");
			$('.publication#' + publicationId + " .hover").removeClass("liked").addClass("unliked");
			$('.publication#' + publicationId + " .hover").stop().fadeOut(200);
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function addUserTag(name)
{
	$.post(setJsPath + "src/php/executor.php", { action: "addUserTag", name: name }, function(data)
	{
		if(data.result == true)
		{
			$("#tags-container").prepend(data.reply);
			$("#tags-container #add-tag #input-container #addtag-input").val("");
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function removeUserTag(tagId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "removeUserTag", tagId: tagId }, function(data)
	{
		if(data.result == true)
		{
			$("#"+ tagId +".tag").fadeOut(200);
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function followUser(userId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "followUser", userId: userId }, function(data)
	{
		if(data.result == 1)
		{
			messageBox("Followed !");
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function unfollowUser(userId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "unfollowUser", userId: userId }, function(data)
	{
		if(data.result == 1)
		{
			messageBox("Unfollowed !");
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function checkToken()
{
	$.post(setJsPath + "src/php/executor.php", { action: "checkToken"}, function(data)
	{
		if(data.result == 1)
		{
			
		}
		else if(data.result == 0)
		{
			logOut();

			messageBox("Vos tokens ne sont plus valide !");
		}
		else if(data.result == -1)
		{
			console.log('Non connecté')
		}

	}, "json");

}

function loadFile(file, div)
{
	$.post(setJsPath + "src/php/executor.php", { action: "loadFile", file: file}, function(data)
	{
		if(data.result == 1)
		{
			$('#include-container').loadingOut();
			$(div).append(data.reply);
			//messageBox("Le fichier " + file + ".php est bien chargé !");
		}
		else
		{
			messageBox("Erreur: le fichier " + file + "n'a pas pu être chargé ...");
		}

	}, "json");
}

function loadPublicationViewer(id, imgCover)
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$.post(setJsPath + "src/php/executor.php", { action: "loadPublicationViewer", id: id}, function(data)
		{
			if(data.result == true & data.reply != "")
			{	
				$("#publicationViewer-container").html(data.reply);

				var imageWidth = imgCover.width;
				var imageHeight = imgCover.height;

				$('#publicationViewer').width(imageWidth);

				var width = $('#publicationViewer').width();

				var height = $('#publicationViewer').height();

				var marginLeft = width /2;
				marginLeft = Math.floor(marginLeft);

				var marginTop = height /2;
				marginTop = Math.floor(marginTop);

				$('#publicationViewer').css({ marginLeft : "-"+ marginLeft +"px", marginTop : "-"+ marginTop +"px" });

				backgroundBox(1);
				$('#publicationViewer').fadeIn();
			}
			else if(data.result == false)
			{

			}
			else
			{
				messageBox("Erreur: le viewer n'a pas pu être chargé ...");
			}

			isBusy = 0;

		}, "json");
	}
}

function loadPostPublication()
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$.post(setJsPath + "src/php/executor.php", { action: "loadPostPublication" }, function(data)
		{
			if(data.result == true & data.reply != "")
			{	
				$("#postPublication-container").html(data.reply);

				backgroundBox(1);
				$('#postPublication').fadeIn();
			}
			else if(data.result == false)
			{

			}
			else
			{
				messageBox("Erreur: post publication n'a pas pu être chargé ...");
			}

			isBusy = 0;

		}, "json");
	}
}

function loadProfil(username)
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$("#include-container").stop().fadeOut(200).queue(function() {
			$('#include-container').html("");

			$.post(setJsPath + "src/php/executor.php", { action: "loadProfil", username: username}, function(data)
			{
				if(data.result == 1 & data.reply != false)
				{	
					$("#include-container").append(data.reply);
					$('#profil-container').fadeIn(200);
					$('#profil-container').loadingOut();
					window.history.pushState({page: 'profil', username: username}, "Profil de " + username, setJsPath + username);
					document.title = "Vluds - Profil de " + username;
				}
				else if(data.reply == false)
				{

				}
				else
				{
					messageBox("Erreur: le profil n'a pas pu être chargé ...");
				}

				isBusy = 0;

			}, "json");

			$("#include-container").stop().fadeIn(100).dequeue();
		});
	}
}

function loadNotifications()
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$("#notifications-viewer").stop().fadeOut(200).queue(function()
		{
			$("#notifications-viewer #content").html("");

			$('#notifications-viewer #content').loadingIn();

			$.post(setJsPath + "src/php/executor.php", { action: "loadNotifications"}, function(data)
			{
				$('#notifications-viewer #content').loadingOut();

				if(data.result == true && data.re != "")
				{	
					$("#notifications-viewer #content").append(data.reply);
				}
				else if(data.result == false || data.reply == "")
				{	
					$("#notifications-viewer #content").html("<p>Aucune notification à afficher ...</p>");
				}
				else
				{
					messageBox("Erreur: la page de notifications n'a pas pu être chargée ...");
				}

				isBusy = 0;

			}, "json");

			$("#notifications-viewer").stop().fadeIn(100).dequeue();
		});
	}
}

function readNotification(notificationId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "readNotification", notificationId: notificationId }, function(data)
	{
		if(data.result == 1)
		{
			messageBox("Read !");
		}
		else
		{
			messageBox("Erreur");
		}

	}, "json");
}

function loadTagsFinder(tag)
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$("#include-container").stop().fadeOut(200).queue(function() {

			window.history.pushState({page: 'tagsfinder', tag: tag}, "Rechercher " + tag, setJsPath + "Search/" + tag);
			document.title = "Vluds - Rechercher " + tag;

			$("#include-container").html("");
			
			loadFile("tagsfinder-container", "#include-container");

			$.post(setJsPath + "src/php/executor.php", { action: "loadTagsFinder", tag: tag}, function(data)
			{
				$("#tagsfinder-container #view-mode #searchbar #searchtag").val(tag);

				if(data.result == 1 && data.reply != "")
				{	
					$('#tagsfinder-container #tags-container').loadingOut();
					$("#tags-container").append(data.reply);
					$('.publication img').load(function(){
						$('.publication').fadeIn(400);
					});
				}
				else if(data.result == 1 && data.reply == "")
				{
					$('#tagsfinder-container #tags-container').loadingOut();
					$("#tags-container").append("<h3>Aucun résultat ne correspond à votre recherche ...</h3>");
				}
				else
				{
					messageBox("Erreur: les résultats de la recherche n'ont pas pu être éfféctués ...");
				}

				isBusy = 0;

			}, "json");

			$("#include-container").stop().fadeIn(100).dequeue();
		});
	}
}

function loadPublicationPage(id)
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$("#include-container").stop().fadeOut(200).queue(function() {
			window.history.pushState({page: 'publication', id: id}, "Publication " + id, setJsPath + "publication/" + id);
			document.title = "Vluds - Publication n°" + id;

			$("#include-container").html("");

			$.post(setJsPath + "src/php/executor.php", { action: "loadPublicationPage", id: id}, function(data)
			{
				if(data.result == 1 && data.reply != "")
				{	
					$("#include-container").append(data.reply);
					$('#publicationviewer-container').fadeIn(200);
					$('#publicationviewer-container').loadingOut();
				}
				else if(data.result == 1 && data.reply == "")
				{
					$("#include-container").append("<h3>Aucune publication associée n'a été trouvée ...</h3>");
				}
				else
				{
					messageBox("Erreur: l'affichage de la publication n'a pas pu être éfféctué ...");
				}

				isBusy = 0;

			}, "json");

			$("#include-container").stop().fadeIn(100).dequeue();
		});
	}
}

function loadManager()
{
	if(isBusy == 0)
	{
		isBusy = 1;

		$("#include-container").stop().fadeOut(200).queue(function() {
			$('#include-container').html("");

			$.post(setJsPath + "src/php/executor.php", { action: "loadManager"}, function(data)
			{
				if(data.result == 1 & data.reply != false)
				{	
					$("#include-container").append(data.reply);
					$('#manage-container').fadeIn(200);
					$('#manage-container').loadingOut();
					window.history.pushState({page: 'manager'}, "Panel administateur", setJsPath + "Manager");
					document.title = "Vluds - Panel administateur";
				}
				else if(data.reply == false)
				{

				}
				else
				{
					messageBox("Erreur: le panel admin n'a pas pu être chargé ...");
				}

				isBusy = 0;

			}, "json");

			$("#include-container").stop().fadeIn(100).dequeue();
		});
	}
}

function sendConfirmationMail(email, username)
{
	$.post(setJsPath + "src/php/executor.php", { action: "sendConfirmationMail", email: email, username: username}, function(data)
	{
		if(data.result == 1)
		{
			messageBox("Un e-mail de comfirmation vous a été envoyé !");
		}
		else
		{
			messageBox("Nous n'avons pas pu vous envoyez l'e-mail ...");
		}

	}, "json");

}

function uploadAvatar(files, avatarFile)
{
	var file = files[0];

	if(file.type.match('image.*'))
	{
	 	function ajaxRequest(callback)
	 	{
		 	var formData = new FormData();
		 	formData.append("action", "uploadAvatar");
		 	formData.append("avatarFile", file);

		 	var xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function() 
			{
		        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
		        {
		            var myArr = JSON.parse(xhr.responseText);
        			callback(myArr);
		        }
			};

			xhr.open('POST', 'src/php/executor.php', true);
			xhr.send(formData);
		}

		function readData(sData) 
		{
			if(sData.result == 1)
			{
				$('#sidebar #profil #avatar img').fadeOut(300)
				.queue(function(){
					$(this).attr("src", setJsPath + sData.reply)
					.dequeue();
				})
				.fadeIn(300);

				if(history.state.page == "profil")
				{
					$('#profil-container #profil #avatar img').fadeOut(300)
					.queue(function(){
						$(this).attr("src", setJsPath + sData.reply)
						.dequeue();
					})
					.fadeIn(500);
				}
				
			    messageBox("Votre avatar à bien été modifié !");
			} 
			else 
			{
			   	messageBox("Nous n'avons pas pu modifier votre avatar ...!");	    
			}
		}

		ajaxRequest(readData);
	}
	else
	{
		messageBox("Le fichier n'est pas une image !");
	}
}

function uploadBanner(files, bannerFile)
{
	var file = files[0];

	if(file.type.match('image.*'))
	{
	 	function ajaxRequest(callback)
	 	{
		 	var formData = new FormData();
		 	formData.append("action", "uploadBanner");
		 	formData.append("bannerFile", file);

		 	var xhr = new XMLHttpRequest();

			xhr.onreadystatechange = function() 
			{
		        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
		        {
		            var myArr = JSON.parse(xhr.responseText);
        			callback(myArr);
		        }
			};

			xhr.open('POST', 'src/php/executor.php', true);
			xhr.send(formData);
		}

		function readData(sData) 
		{
			if(sData.result == 1)
			{
				if(history.state.page == "profil")
				{
					$('#profil-container #banner').fadeOut(300)
					.queue(function(){
						$(this).css({"background-image" : "url('" + setJsPath + sData.reply + "')"})
						.dequeue();
					})
					.fadeIn(500);
				}
				
			    messageBox("Votre bannière à bien été modifiée !");
			} 
			else 
			{
			   	messageBox("Nous n'avons pas pu modifier votre bannière ...!");	    
			}
		}

		ajaxRequest(readData);
	}
	else
	{
		messageBox("Le fichier n'est pas une image !");
	}
}

function postPublication(publicationFile, publicationContent, publicationTags)
{
	function ajaxRequest(callback)
	{
		var formData = new FormData();
		formData.append("action", "postPublication");

		formData.append("publicationFile", publicationFile[0].files[0]);

		formData.append("publicationContent", publicationContent); 
		formData.append("publicationTags", publicationTags);

		var xhr = new XMLHttpRequest();

		xhr.onreadystatechange = function() 
		{
		    if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) 
		    {
		        var myArr = JSON.parse(xhr.responseText);
        		callback(myArr);
		    }
		};

		xhr.open('POST', 'src/php/executor.php', true);
		xhr.send(formData);
	}

	function readData(sData) 
	{
		if(sData.result == 1)
		{		
			backgroundBox(0);
			$('#addPublication').fadeOut(400);

			loadPostPublication();

			loadPublicationPage(sData.id);

			messageBox("Votre publication à bien été ajoutée !");
		} 
		else if(sData.result == -1)
		{
			messageBox("Vous n'avez pas rempli tout les champs !");	    
		}
		else
		{
			messageBox("Owh :( Nous n'avons pas pu ajouter votre publication ...");	    
		}
	}

	ajaxRequest(readData);
}

function deletePublication(publicationId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "deletePublication", publicationId: publicationId }, function(data)
	{
		if(data.result == true)
		{
			$(".publication#"+ publicationId).fadeOut(400);
		}
		else
		{
			messageBox("Erreur lors de la suppression de la publication ...");
		}

	}, "json");
}

function deletePublicationManage(publicationId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "deletePublication", publicationId: publicationId }, function(data)
	{
		if(data.result == true)
		{
			$(".manager_table__publication#"+ publicationId).fadeOut(400);
		}
		else
		{
			messageBox("Erreur lors de la suppression de la publication ...");
		}

	}, "json");
}

function deleteUser(userId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "deleteUser", userId: userId }, function(data)
	{
		if(data.result == true)
		{
			$(".manager_table__user#"+ userId).fadeOut(400);
		}
		else
		{
			messageBox("Erreur lors de la suppression de l'utilisateur' ...");
		}

	}, "json");
}

function changeUserRole(userId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "changeUserRole", userId: userId}, function(data)
	{
		if(data.result == true)
		{
			if(data.returnRole == 1){
				$('#'+ userId +'.manager_table__td__button__admin').removeClass('false');
				$('#'+ userId +'.manager_table__td__button__admin').addClass('true');
				$('#'+ userId +'.manager_table__td__button__admin').html('✓');
			} else {
				$('#'+ userId +'.manager_table__td__button__admin').removeClass('true');
				$('#'+ userId +'.manager_table__td__button__admin').addClass('false');
				$('#'+ userId +'.manager_table__td__button__admin').html('☓');
			}
		}
		else
		{
			messageBox("Erreur lors de la modification des droits de l'utilisateur' ...");
		}

	}, "json");
}

function deleteComment(commentId)
{
	$.post(setJsPath + "src/php/executor.php", { action: "deleteComment", commentId: commentId }, function(data)
	{
		if(data.result == true)
		{
			$(".comment#"+ commentId).fadeOut(400);
		}
		else
		{
			messageBox("Erreur lors de la suppression du commentaire ...");
		}

	}, "json");
}