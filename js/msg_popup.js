$(document).ready(function(){


	
//SEND MESSAGE-----------------------

	$('#msg_pop').click(function(){
		$('.pop').slideFadeToggle(function() { 
                $("#msg_sendie").focus();
            });
		return false;
	});

	$('#cancel_msg').click(function(){
		$('.pop').slideFadeToggle(function(){
			$('#msg_sendie').val('');
        	$('#send_message_area').show();
        	$('#msg_sent').hide();
        	$('#msg_sent').html('');
        	$('#msg_label').text('New Message');
        });
	});

	$('#send_msg').click(function(){
		//alert('hello');
		$('#send_message_area').hide();
        $('#msg_sent').show();
		$('#msg_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /><p>Sending...</p></div>');
	});


	jQuery.fn.slideFadeToggle = function(easing, callback) {
    return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	

//INVITE USER---------------------------

	var $invite = $('#msg_sendie_invite').val();

	$('#pop_invite, #pop_invite_top').click(function(){
		$('.pop_invite').slideFadeToggle();
		return false;
	});

	$('#cancel').click(function(){
		$('.pop_invite').slideFadeToggle(function(){
			$('#msg_sendie_invite').val('');
        	$('#send-message-area').show();
        	$('#invite_sent').hide();
        	$('#invite_sent').html('');
        	/*
        	$('#first_name_invite').val('first name');
        	$('#last_name_invite').val('last name');
        	$('#their_name_invite').val('name');
        	$('#their_email_invite').val('email');
        	*/
        });
	});

	$('.pop_close').click(function(){
		$('.pop_invite').slideFadeToggle(function(){
			$('#msg_sendie_invite').val('');
        	$('#send-message-area').show();
        	$('#invite_sent').hide();
        	$('#invite_sent').html('');
        	/*
        	$('#first_name_invite').val('first name');
        	$('#last_name_invite').val('last name');
        	$('#their_name_invite').val('name');
        	$('#their_email_invite').val('email');
        	*/
        });
	});


	$('#send_invite').click(function(){
							$('#send-message-area').hide();
             				$('#invite_sent').show();
							$('#invite_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /><p>Sending...</p></div>');
					});



//REPORT USER----------------------

	$('#report_pop').click(function(){
		$('.pop_report').slideFadeToggle();
		return false;
	});

	$('#cancel_report').click(function(){
		$('.pop_report').slideFadeToggle();
		$('#additional_comments').val('');
	});

	$('#send_report').click(function(){
		$('.report_text').hide();
		$('#send_report').hide();
		$('#cancel_report').hide();
		$('#report_sent').show();
		$('#report_sent').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /><p>Sending...</p></div>');
		$('#additional_comments').hide();
		$('#comments_label').hide();
		//$('#msg_sheen_content_report').height('auto');
	});

	$('#close_report').click(function(){
		$('.pop_report').slideFadeToggle(function(){
			$('#close_report').hide();
			$('#report_sent').hide();
			$('.report_text').show();
			$('#send_report').show();
			$('#cancel_report').show();
			$('#additional_comments').show();
			$('#additional_comments').val('');
			$('#comments_label').show();
			//$('#msg_sheen_content_report').height('212px');
		});
	});

});