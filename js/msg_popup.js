$(document).ready(function(){


	//Send Message
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

	$('.msg_send').click(function(){
							$('#send-message-area').hide();
             				$('#msg_sent').show();
							$('#msg_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader.gif" /><p>Sending...</p></div>');
					});


	jQuery.fn.slideFadeToggle = function(easing, callback) {
    return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	

	//Invite User
	var $invite = $('#msg_sendie_invite').val();

	$('#pop_invite').click(function(){
		$('.pop_invite').slideFadeToggle();
		return false;
	});

	$('.msg_cancel_invite').click(function(){
		$('.pop_invite').slideFadeToggle(function(){
			$('#msg_sendie_invite').val('');
        	$('#send-message-area').show();
        	$('#msg_sent').hide();
        	$('#msg_sent').html('');
        	$('#first_name_invite').val('first name');
        	$('#last_name_invite').val('last name');
        	$('#their_name_invite').val('name');
        	$('#their_email_invite').val('email');
        });
	});

	$('.msg_send_invite').click(function(){
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
		$('#additional_comments').val('');
	});

	$('.report_send').click(function(){
		$('.report_text').hide();
		$('.report_send').hide();
		$('.report_cancel').hide();
		$('#report_sent').show();
		$('#report_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader.gif" /><p>Sending...</p></div>');
		$('#additional_comments').hide();
		$('#comments_label').hide();
		$('#msg_sheen_content_report').height('auto');
	});

	$('.report_close').click(function(){
		$('.pop_report').slideFadeToggle(function(){
			$('.report_close').hide();
			$('#report_sent').hide();
			$('.report_text').show();
			$('.report_send').show();
			$('.report_cancel').show();
			$('#additional_comments').show();
			$('#additional_comments').val('');
			$('#comments_label').show();
			$('#msg_sheen_content_report').height('212px');
		});
	});

});