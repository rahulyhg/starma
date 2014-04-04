$(document).ready(function(){

	$('#msg_pop').bind('click', function(){
		$('.pop').slideFadeToggle(function() { 
                $("#msg_sendie").focus();
            });
		return false;
	});

	$('.cancel').bind('click', function(){
		$('.pop').slideFadeToggle();
	});

	jQuery.fn.slideFadeToggle = function(easing, callback) {
    return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

});