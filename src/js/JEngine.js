var checkToken = setInterval(checkToken, 10000);

$(document).on('click', function() 
{
	setTime();
});

function adaptPublications(containerHeight, nbLinePerHeight)
{
	

	$('.publication').animate({ margin: '+' + margin + 'px' }, 500);
	$('.profil-publication').animate({ margin: '+' + margin + 'px' }, 500);
}

checkAcceptationCookies();

function checkAcceptationCookies()
{
	var cookieValue = getCookie('AcceptationCookies');

	if(cookieValue != 1)
	{
		cookiesBox(1);
	}
	else
	{
		cookiesBox(0);
	}
}

function AcceptCookies()
{
	var today = new Date(), expires = new Date();
	expires.setTime(today.getTime() + (365*24*60*60*1000));
	document.cookie = "AcceptationCookies =" + encodeURIComponent(1) + ";expires=" + expires.toGMTString();

	cookiesBox(0);
}

function getCookie(cookieName) 
{
    var oRegex = new RegExp("(?:; )?" + cookieName + "=([^;]*);?");
 
	if (oRegex.test(document.cookie))
    {
		return decodeURIComponent(RegExp["$1"]);
	} 
	else 
	{
		return null;
	}
}

function delDiv(div, time)
{
    $(div).fadeOut(time).queue(function() { $(div).remove(); });
}

$(document).on('click', 'section#sidebar ul#profil #state', function(){
	logOut();
});


function loadSideBar()
{
	delDiv("#sidebar_ajax_container", 400);
	$('#sidebar').loadingOut();
	loadFile('sideBar', '#sidebar');
}

$(document).on('click', '#regBox #container #submit input', function()
{
	var email = $('#regBox #container input#email').val();
	var password = $('#regBox #container input#password').val();
	var username = $('#regBox #container input#username').val();

	regUser(email, password, username);
});

$(document).on('click', '#signBox #container #submit input', function()
{
	var username = $('#signBox #container input#username').val();
	var password = $('#signBox #container input#password').val();

	logUser(username, password);
});


//////POST PUBLICATION//////
$(document).on('click', '.option-button#add-file', function()
{
	$(this).parent().find('#file-upload').click();
});

$(document).on('change', '#postPublication .options-container #file-upload', function(event) 
{
	$('#postPublication .file-viewer .object-slider').html("");
	$('#postPublication .file-viewer .object-slider').width(0);

	$('#postPublication .file-viewer .object-slider').loadingIn();

	for (var i = 0; i < this.files.length; i++)
	{
		var selectedFile = event.target.files[i];
		var reader = new FileReader();

		reader.onload = function(event)
		{	
			$('#postPublication .file-viewer').fadeIn(400);

			$('#postPublication .file-viewer .object-slider').width($('#postPublication .file-viewer .object-slider').width() + 205);

			$('#postPublication .file-viewer .object-slider').loadingOut();

			if(selectedFile.type.match("image.*")) 
			{
				$('#postPublication .file-viewer .object-slider').prepend('<div class="object-viewer"><img src="' + event.target.result + '"/><div class="align-middle"></div></div>');
			}
			else
			{
				$('#postPublication .file-viewer .object-slider').html('<p>' + selectedFile.name + '</p>');
			}
		}

		reader.readAsDataURL(selectedFile);
	}
});
$(document).on('click', '#postPublication .submit-publication input', function() 
{
	var publicationContent = $('#postPublication .post-content textarea').val();
	var publicationTags = $('#postPublication .tags-container input').val();

	var publicationFile = $('#postPublication .options-container #file-upload');

    postPublication(publicationFile, publicationContent, publicationTags);
});




$(document).on('click', '#profil-container #banner #changeBanner', function()
{
	$('#profil-container #banner input#banner-upload').click();
});

$(document).on('change', '#profil-container #banner input#banner-upload', function(event) 
{
	var bannerFile = $('#profil-container #banner input#banner-upload').val();

    uploadBanner(event.target.files, bannerFile);
});


$(document).on('click', '#profil-container #profil #avatar #addAvatar', function()
{
	$('#profil-container #profil #avatar input#avatar-upload').click();
});

$(document).on('change', '#profil-container #profil #avatar input#avatar-upload', function(event) 
{
	var avatarFile = $(this).val();

    uploadAvatar(event.target.files, avatarFile);
});



$(document).on('change', '#addPublication #container #artwork-cover-upload', function(event) 
{
	var selectedFile = event.target.files[0];
	var reader = new FileReader();

	reader.onload = function(event)
	{	
		if(selectedFile.type.match("image.*")) 
		{
			$('#artworkImg').fadeOut(200);
			$('#addPublication #container #artwork-container #artworkImg').html('<img id="artworkLoaded" src="' + event.target.result + '"/>');
			$('#artworkImg').fadeIn(800);
		}
		else
		{
			messageBox("Le fichier séléctionné n'est pas une image !");
		}
	}

	reader.readAsDataURL(selectedFile);
});

// horizontalScroll
$(document).on('mousewheel', '#flux-container', function(e, delta){
	this.scrollLeft -= (delta * 100);
	e.preventDefault();
});

jQuery(function($) {
    $('#flux-container').bind('scroll', function() {
        if($(this).scrollLeft() + $(this).innerWidth() >= this.scrollWidth) {
            alert('end reached');
        }
    })
});