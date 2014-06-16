$(document).ready(function(){

	var $invite = $('#msg_sendie').val();

	$('#msg_pop').click(function(){
		$('.pop').slideFadeToggle(function() { 
                $("#msg_sendie").focus();
            });
		return false;
	});

	$('.msg_cancel').click(function(){
		$('.pop').slideFadeToggle(function(){
			$('#msg_sendie').val('');
        	$('#send-message-area').show();
        	$('#msg_sent').hide();
        	$('#msg_sent').html('');
        	$('#msg_label').text('New Message');
        });
	});

	$('.msg_cancel_invite').click(function(){
		$('.pop').slideFadeToggle(function(){
			$('#msg_sendie').val($invite);
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

	$('.msg_send').click(function(){
							$('#send-message-area').hide();
             				$('#msg_sent').show();
							$('#msg_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader.gif" /><p>Sending...</p></div>');
					});


	//Report User

	$('#report_pop').click(function(){
		$('.pop_report').slideFadeToggle();
		return false;
	});

	$('.report_cancel').click(function(){
		$('.pop_report').slideFadeToggle();
	});

	$('.report_send').click(function(){
		$('.report_text').hide();
		$('.report_send').hide();
		$('.report_cancel').hide();
		$('#report_sent').show();
		$('#report_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader.gif" /><p>Sending...</p></div>');
	});

	$('.report_close').click(function(){
		$('.pop_report').slideFadeToggle(function(){
			$('.report_close').hide();
			$('#report_sent').hide();
			$('.report_text').show();
			$('.report_send').show();
			$('.report_cancel').show();
		});
	});

});