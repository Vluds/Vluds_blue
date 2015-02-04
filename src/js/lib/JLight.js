(function($) {

    $.fn.loadingIn = function(){ 

        $(this).prepend('<div class="loading"></div>');

        return this;
    }

    $.fn.loadingOut = function(){ 

        $('.loading', this).fadeOut(400);

        return this;
    };

    $.fn.hover = function(effect, argument){ 

        $(this).on('mouseenter', function(){
            $(this).stop().effect(argument);
        });

        return this;
    };

    $.fn.hoverFade = function(opacity, time){ 

        var defaultOpacity = $(this).css('opacity');

        $(this).on('mouseenter', function(){
            $(this).stop().animate({opacity: '' + opacity + ''}, '' + time + '');
        }).on('mouseleave', function(){
            $(this).stop().animate({opacity: '' + defaultOpacity + ''}, time);
        });

        return this;
    };

    $.fn.opacity = function(opacity, time){ 

        $(this).animate({opacity: opacity}, time);

        return this;
    };

    $.fn.darkFade = function(opacity, time){ 

        var defaultRGB = $(this).css('background-color');

        $(this).animate({backgroundColor: "rgba(0, 0, 0, " + opacity + ")"}, time);

        return this;
    };

    $.fn.lightFade = function(opacity, time){ 

        $(this).animate({backgroundColor: "rgba(255, 255, 255, " + opacity + ")"}, time);

        return this;
    };

    $.fn.backgroundColorFade = function(color, time){ 

        $(this).animate({backgroundColor: color}, time);

        return this;
    };

    $.fn.borderRight = function(width, color, time){ 

        $(this).css({'border-right': '0px solid ' + color});
        $(this).animate({borderWidth: width}, time);

        return this;
    };

    $.fn.borderTop = function(width, color, time){ 

        $(this).css({'border-top': '0px solid ' + color});
        $(this).animate({borderWidth: width}, time);

        return this;
    };

    $.fn.border = function(width, color, time){ 

        $(this).css({'border': '0px solid ' + color});
        $(this).animate({borderWidth: width}, time);

        return this;
    };

    $.fn.borderColor = function(color, time){ 

        $(this).animate({ 'border-color' : color}, time);

        return this;
    };

    $.fn.rollUp = function(time){ 

        $(this).animate({height: '0px'}, time);
        $(this).fadeOut(0);

        return this;
    };

    $.fn.rollDown = function(time, height){ 

        $(this).animate({height: height}, time);
        $(this).fadeIn(200);

        return this;
    };

    $.fn.slideIn = function(width, time){ 

        $(this).animate({width: width}, time).fadeIn(time);

        return this;
    };  

    $.fn.slideOut = function(time){ 

        $(this).animate({width: "0px"}, time).fadeOut(time);

        return this;
    };

    $.fn.rotate = function(angle, time)
    {
        $(this).stop().animate({borderSpacing: + angle}, {
            duration: time,
            step: function(now) {
              $(this).css('-webkit-transform','rotate('+now+'deg)'); 
              $(this).css('-moz-transform','rotate('+now+'deg)');
              $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0);

        return this;
    }

    $.fn.flip = function(angle, time)
    {
        time = time / 2;

        $(this).stop().animate({borderSpacing: + angle}, {
            duration: time,
            step: function(now) {
              $(this).css('-webkit-transform','rotate('+now+'deg)'); 
              $(this).css('-moz-transform','rotate('+now+'deg)');
              $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0)
        .animate({borderSpacing: + 0}, {
            duration: time,
            step: function(now) {
              $(this).css('-webkit-transform','rotate('+now+'deg)'); 
              $(this).css('-moz-transform','rotate('+now+'deg)');
              $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0);
    }

    $.fn.shake = function(time)
    {
        time = time / 3;

        $(this).stop()
        .animate({borderSpacing: + 15}, {
            duration: time,
            step: function(now) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0)
        .animate({borderSpacing: - 15}, {
            duration: time,
            step: function(now) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0)
        .animate({borderSpacing: - 0}, {
            duration: time,
            step: function(now) {
                $(this).css('-webkit-transform','rotate('+now+'deg)'); 
                $(this).css('-moz-transform','rotate('+now+'deg)');
                $(this).css('transform','rotate('+now+'deg)');
            }
        }, 0);
    }

    $.fn.wiggle = function(time)
    {
       time = time / 3;

        $(this).stop()
        .animate({borderSpacing: + 5}, {
            duration: time,
            step: function(now) {
                $(this).css('-webkit-transform', 'translate('+now+'px, 0px)'); 
                $(this).css('-moz-transform', 'translate('+now+'px, 0px)'); 
                $(this).css('transform', 'translate('+now+'px, 0px)'); 
            }
        }, 0)
        .animate({borderSpacing: - 5}, {
            duration: time,
            step: function(now) {
                $(this).css('-webkit-transform', 'translate('+now+'px, 0px)'); 
                $(this).css('-moz-transform', 'translate('+now+'px, 0px)'); 
                $(this).css('transform', 'translate('+now+'px, 0px)'); 
            }
        }, 0)
        .animate({borderSpacing: - 0}, {
            duration: time,
            step: function(now) {
                $(this).css('-webkit-transform', 'translate('+now+'px, 0px)'); 
                $(this).css('-moz-transform', 'translate('+now+'px, 0px)'); 
                $(this).css('transform', 'translate('+now+'px, 0px)'); 
            }
        }, 0);
    }

})(jQuery);