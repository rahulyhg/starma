$(document).ready(function(){

	$('#msg_pop').bind('click', function(){
		$('.pop').slideFadeToggle(function() { 
                $("#msg_sendie").focus();
            });
		return false;
	});

	$('.msg_cancel').bind('click', function(){
		$('.pop').slideFadeToggle(function(){
			$('#msg_sendie').val('');
        	$('#send-message-area').show();
        	$('#msg_sent').hide();
        	$('#msg_sent').html('');
        	$('#msg_label').text('New Message');
        	$('#email_label').text('Email Address');
        	$('#email_invite').val('');
        });
	});

	jQuery.fn.slideFadeToggle = function(easing, callback) {
    return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	$('.msg_send').bind('click', function(){
							$('#send-message-area').hide();
             				$('#msg_sent').show();
							$('#msg_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader.gif" /><p>Sending...</p></div>');
			
					});

});