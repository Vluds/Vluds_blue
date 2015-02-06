$(document).on('click', '#post-comment #post-content #submit-comment input', function() 
{
	var publicationId = $(this).parents("#post-comment").attr("ref");
	var content = $(this).parents("#post-comment").find("#textarea-container textarea").val();

	postComment(publicationId, content);
});

$(document).on('focus', '#post-comment #post-content textarea', function(event)
{
    
});
$(document).on('focusout', '#post-comment #post-content textarea', function(event)
{
    $("#post-content").animate({width: 370}, 200);
});

$(document).on('keydown', 'textarea.resize-auto', function(event)
{
    $(this).height(0);
    $(this).height(this.scrollHeight);

    $(this).parent().height($(this).height);
});

$(document).on('click', '#slider', function() {
	if($("#sidebar").attr('class') == "active")
	{
		$("#sidebar").stop().animate({width: "0px"}).fadeOut(0);
		$("section#include-container").stop().animate({paddingLeft: "0px"});

		$("#sidebar").attr('class', 'unactive');
	}
});

$(document).on('mouseenter', '#slider', function() {
	$('img', this).rotate(90, 200);
}).on('mouseleave', '#slider', function(){
	$('img', this).rotate(0, 100);
});

$(document).on('click', '#slideBar', function() {
	$("#sidebar").stop().fadeIn(0).animate({width: "200px"});
	$("section#include-container").stop().animate({paddingLeft: "200px"});

	$(this).stop().animate({left: "170px"}).rotate(0, 200);

	$("#sidebar").attr('class', 'active')
});

$(document).on('mouseenter', '#profil-container #banner', function() {
	$('#changeBanner', this).stop().fadeIn(400);
}).on('mouseleave', '#profil-container #banner', function(){
	$('#changeBanner', this).stop().fadeOut(200);
});

$(document).on('mouseenter', '#profil-container #banner #changeBanner', function() {
	$('.info', this).stop().fadeIn(400);
}).on('mouseleave', '#profil-container #banner #changeBanner', function() {
	$('.info', this).stop().fadeOut(200);
});


$(document).on('mouseenter', 'section#sidebar ul#profil #avatar', function(){
	$('#profilEdit', this).stop().fadeIn(400);
}).on('mouseleave', 'section#sidebar ul#profil #avatar', function(){
	$('#profilEdit', this).stop().fadeOut(200);
});

$(document).on('mouseenter', 'section#sidebar ul#profil #avatar #profilEdit', function(){
	$('.info', this).stop().fadeIn(400);
}).on('mouseleave', 'section#sidebar ul#profil #avatar #profilEdit', function(){
	$('.info', this).stop().fadeOut(200);
});

$(document).on('mouseenter', 'section#sidebar ul#profil #addName .input-container .check', function(){
	$('p', this).stop().animate({"color": "rgba(10, 10, 10, 1)"});
}).on('mouseleave', 'section#sidebar ul#profil #addName .input-container .check', function(){
	$('p', this).stop().animate({"color": "rgba(10, 10, 10, 0.5)"});
});

$(document).on('mouseenter', 'input[type=submit]', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 200);
}).on('mouseleave', 'input[type=submit]', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 100);
});
$(document).on('mouseenter', 'input[type=text]', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 200);
}).on('mouseleave', 'input[type=text]', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 100);
});
$(document).on('mouseenter', 'input[type=password]', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 200);
}).on('mouseleave', 'input[type=password]', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 100);
});
$(document).on('mouseenter', 'input[type=email]', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 200);
}).on('mouseleave', 'input[type=email]', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 100);
});
$(document).on('mouseenter', 'textarea', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 200);
}).on('mouseleave', 'textarea', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 100);
});


$(document).on('mouseenter', 'section#sidebar nav ul li.unactive', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 400);
}).on('mouseleave', 'section#sidebar nav ul li.unactive', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0)", 200);
});

$(document).on('click', 'section#sidebar nav ul li', function(){
	$('section#sidebar nav ul li.active').stop().animate({"background-color": "rgba(10, 10, 10, 0)"}).borderRight(0, 'rgba(10, 10, 10, 0.1)', 100);
	$('section#sidebar nav ul li.active').attr('class', 'unactive');

	$(this).attr('class', 'active');
	$(this).stop().animate({"background-color": "rgba(10, 10, 10, 0.1)"}).borderRight(4, 'rgba(10, 10, 10, 0.1)', 100);
});

$(document).on('click', 'section#sidebar ul#profil #addName', function(){
	$('#text-indication', this).fadeOut(100);
	$('.input-container', this).fadeIn(400);
});


$(document).on('mouseenter', '#addPublication #container ul li#artwork-container #addArtwork', function(){
	$(this).stop().opacity(1, 400);
}).on('mouseleave', '#addPublication #container ul li#artwork-container #addArtwork', function(){
	$(this).stop().opacity(0.7, 200);
});


/////TAG/////
$(document).on('mouseenter', '.tag', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 400);
	$('.remove', this).stop().opacity(1, 200);
}).on('mouseleave', '.tag', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0)", 200);
	$('.remove', this).stop().opacity(0, 200);
});

$(document).on('mouseenter', '.tag .remove', function(){
	$('img', this).stop().rotate(90, 200);
}).on('mouseleave', '.tag .remove', function(){
	$('img', this).stop().rotate(0, 200);
});

$(document).on('click', '.tag .content', function(){
	var name = $(this).parent().attr("name");

	loadTagsFinder(name);
});

$(document).on('click', '#profil-container #infos #tags-container .tag .remove', function(){
	var id = $(this).parent().attr("id");

	removeUserTag(id);
});

$(document).on('keypress', '#profil-container #infos #tags-container #add-tag #input-container #addtag-input', function(event){
	if(event.keyCode == '13')
	{
     	var name = $(this).val();

		addUserTag(name);
   	}
});

$(document).on('click', '#profil-container #infos #tags-container #add-tag', function(){
	$('#text', this).fadeOut(100);
	$('#addtag-input', this).fadeIn(200);
});

$(document).on('click', '#profil-container #infos #tags-container #add-tag #text', function(){
	$(this).fadeOut(100);
	$(this).parent().find("#input-container").fadeIn(200);
});






$(document).on('mouseenter', '.follow-container', function(){
	$(this).stop().backgroundColorFade("rgba(120, 120, 120, 0.1)", 400);
}).on('mouseleave', '.follow-container', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 200);
});

$(document).on('click', '.follow-container', function(event){
	var state = $(this).attr("state");
	var userId =  $(this).attr("id");

	if(state == "unactivate")
	{
		$(this).attr("state", "activate");
		$('h3', this).html("Suivi");

		followUser(userId);
	}
	else
	{
		$(this).attr("state", "unactivate");
		$('h3', this).html("Suivre");

		unfollowUser(userId);
	}
});

$(document).on('click', '.publication', function(){

	var publicationId = $(this).attr('id');

	var publicationDiv = $(this);

	$('#publicationViewer').attr('ref', publicationId);
	$('#publicationViewer #post-comment').attr('ref', publicationId);

	$('#publicationViewer #cover #cover-container').html("");

	$('#publicationViewer #cover #cover-container').html($(publicationDiv).find('.cover').html());
	$('#publicationViewer #infos-container #time').html($(publicationDiv).find('.time').html());
	$('#publicationViewer #infos-container #profil').html($(publicationDiv).find('.profil').html());

	var background;
	if(background = publicationDiv.find('.cover'))
	{
		background.css(["background-image", "background-size", "background-repeat", "background-position"]);
		$('#publicationViewer #cover').css({"background-image": background["background-image"], "background-size": background["background-size"], "background-repeat": background["background-repeat"], "background-position": background["background-position"]});
		$('#publicationViewer #infos-container #description').html(publicationDiv.find('.description').html());
		$('#publicationViewer #infos-container #tags-container').html(publicationDiv.find('.tags-container').html());
	}

	var screenImage = $('img', this);

	var theImage = new Image();
	theImage.src = screenImage.attr("src");

	var imageWidth = theImage.width;
	var imageHeight = theImage.height;

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
});

$(document).on('click', '.more', function(){
	$('.more').next().stop().slideUp(200);
	$(this).next().stop().slideToggle(200);
});

$(document).on('mouseenter', '.menu li', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 200);
}).on('mouseleave', '.menu li', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0)", 200);
});

$(document).on('mouseenter', 'section#include-container .publication .cover', function(){
	$('.options', this).stop().fadeIn(400);
}).on('mouseleave', 'section#include-container .publication .cover', function(){
	$('.options', this).stop().fadeOut(200);
});

$(document).on('mouseenter', 'section#include-container .publication .cover .options .like.unliked', function(){
	$('.hover.unliked', this).stop().fadeIn(400);
}).on('mouseleave', 'section#include-container .publication .cover .options .like.unliked', function(){
	$('.hover.unliked', this).stop().fadeOut(200);
});

$(document).on('click', 'section#include-container .publication .cover .options .like.unliked', function()
{
	var publicationId = $(this).closest(".publication").attr("id");

	likePublication(publicationId);
});
$(document).on('click', 'section#include-container .publication .cover .options .like.liked', function()
{
	var publicationId = $(this).closest(".publication").attr("id");

	unlikePublication(publicationId);
});


$(document).on('mouseenter', '#publicationViewer', function(){
	$('#cross', this).stop().fadeIn(800);
	$('#hover', this).stop().fadeIn(800);
}).on('mouseleave', '#publicationViewer', function(){
	$('#cross', this).stop().fadeOut(400);
	$('#hover', this).stop().fadeOut(400);
});

$(document).on('mouseenter', '#publicationViewer #cover #hover #expand', function(){
	$(this).stop().animate({'background-size': '80%'}, 200);
}).on('mouseleave', '#publicationViewer #cover #hover #expand', function(){
	$(this).stop().animate({'background-size': '65%'}, 100);
});

$(document).on('click', '#publicationViewer #cover #hover #expand', function(){
	var publicationId = $('#publicationViewer').attr('ref');

	loadPublicationViewer(publicationId);

	$('#backgroundBox').fadeOut(400);
	$("#publicationViewer").fadeOut(800);
});

$(document).on('mouseenter', 'submit', function(){
	$(this).stop().animate({boxShadow : "0px 0px 0px 2px rgba(10, 10, 10, 0.1)"});
}).on('mouseleave', 'submit', function(){
	$(this).stop().animate({boxShadow : "0px 0px 0px 0px rgba(10, 10, 10, 0.1)"});
});

$(document).on('mouseenter', '.box .close', function(){
	$('img', this).stop().rotate(90, 200);
}).on('mouseleave', '.box .close', function(){
	$('img', this).stop().rotate(0, 200);
});

$(document).on('click', '.box .close', function(){
	backgroundBox(0);
	$(this).parent('.box').fadeOut(200);
});

$(document).on('click', 'section#sidebar ul#profil #submit-container input[type=submit]#sign', function(){
	signBox(1);
});

$(document).on('click', 'section#sidebar ul#profil #submit-container input[type=submit]#reg', function(){
	regBox(1);
});

$(document).on('click', '#sidebar nav ul #submit-artwork input', function(){
	backgroundBox(1);
	$("#postPublication").fadeIn(400);
});

$(document).on('click', '.box #cross', function(){
	backgroundBox(0);
	$(".box").fadeOut(200);
});

$(document).on('mouseenter', '#profil-container #profil #avatar', function(){
	$('#addAvatar', this).stop().fadeIn(400);
}).on('mouseleave', '#profil-container #profil #avatar', function(){
	$('#addAvatar', this).stop().fadeOut(200);
});

$(document).on('mouseenter', '#profil-container #profil #avatar #addAvatar', function(){
	$('.info', this).stop().fadeIn(400);
}).on('mouseleave', '#profil-container #profil #avatar #addAvatar', function(){
	$('.info', this).stop().fadeOut(200);
});

$(document).on('keyup', '#searchbar #searchtag', function(e) 
{
	if(e.keyCode == 13)
	{
		var searchtag = $(this).val();

    	loadTagsFinder(searchtag);
	}
});

$(document).on('click', 'section#sidebar nav li#notifications-li', function(){
	loadNotifications();
	$('.left-arrow', this).fadeIn(400);
});
$(document).on('click', 'section#sidebar nav ul#notifications-viewer #close', function(){
	$(this).parent().fadeOut(200);
	$('#notifications-li .left-arrow').fadeOut(200);
});

$(document).on('mouseenter', 'section#sidebar nav ul#notifications-viewer #close', function(){
	$('img', this).stop().rotate(90, 200);
}).on('mouseleave', 'section#sidebar nav ul#notifications-viewer #close', function(){
	$('img', this).stop().rotate(0, 200);
});

$(document).on('mouseenter', 'section#sidebar nav ul#notifications-viewer #content .notification', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0.1)", 200);
}).on('mouseleave', 'section#sidebar nav ul#notifications-viewer #content .notification', function(){
	$(this).stop().backgroundColorFade("rgba(10, 10, 10, 0)", 100);
});
$(document).on('click', 'section#sidebar nav ul#notifications-viewer #content .notification', function(){
	var notificationId = $(this).attr("id");
	
	readNotification(notificationId);
});

$(document).on('mouseenter', '.option-button', function(){
	$(this).stop().borderColor("rgba(10, 10, 10, 1)", 200);
	$('img', this).stop().opacity(1, 400);

	$('.info', this).stop().fadeIn(200);
}).on('mouseleave', '.option-button', function(){
	$(this).stop().borderColor("rgba(10, 10, 10, 0.7)", 100);
	$('img', this).stop().opacity(0.7, 400);

	$('.info', this).stop().fadeOut(100);
});

function signBox(state)
{
	if(state == 0)
	{
		$('#signBox').fadeOut(200);
	}
	else
	{
		backgroundBox(1);
		$('#signBox').fadeIn(400);
		$('#signBox #container #username').focus();
	}
}

function regBox(state)
{
	if(state == 0)
	{
		$('#regBox').fadeOut(200);
	}
	else
	{
		backgroundBox(1);
		$('#regBox').fadeIn(400);
	}
}

function cookiesBox(state)
{
	if(state == 0)
	{
		backgroundBox(0);
		$('#cookiesBox').fadeOut(200);
	}
	else
	{
		backgroundBox(1);
		$('#cookiesBox').fadeIn(400);
	}
}

$('#backgroundBox').on('click', function(){
	backgroundBox(0);
});

function backgroundBox(state)
{
	if(state == 0)
	{
		$(".box").fadeOut(200);
		$('#backgroundBox').fadeOut(100);
	}
	else
	{
		$('#backgroundBox').fadeIn(400);
	}
}

function messageBox(message)
{
	var randId = "";
    var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

    for( var i=0; i < 5; i++ )
        randId += possible.charAt(Math.floor(Math.random() * possible.length));

	$('#messageBox_container').append('<div class="messageBox" id="' + randId + '"><p>null</p></div>');

	$('#'+ randId +' p').html(message);
	$('#'+ randId).fadeIn(400).delay(4000).fadeOut(400).queue(function() { $('#'+ randId).remove(); });
}

/*$("#include-container").mousewheel(function(event, delta) 
{
	this.scrollLeft -= (delta * 30);
	event.preventDefault();
});

$("#profil-container").mousewheel(function(event, delta) 
{
	this.scrollTop -= (delta * 40);
	event.preventDefault();
});*/ 