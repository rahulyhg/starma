$(document).ready(function(){

	//var $invite = $('#msg_sendie').val();
	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	$('.pop_guest_login').click(function(){
		$('.pop_login').slideFadeToggle();
	});

	$('.pop_guest_click').click(function(event){
		event.preventDefault();
		$('.pop_guest').slideFadeToggle();
		return false;
	});

	$('.pop_reg').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
			$('#login_box').show();
			$('#forgot_password_box').hide();
		});
	});

	$('.pop_log').click(function(){
		$('.pop_login').slideFadeToggle(function() {
			$('#login_box').show();
			$('#forgot_password_box').hide();
		});
	});

	$('#cancel_email_sign_up').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
		});
	});


	$('button[name=sign_up]').click(function(){
		$('#sign_up_box').hide();
		$('#create_account').show();
	});

	$('button[name=cancel]').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').hide();
		});
	});

	$('#forgot_password').click(function(){
		$('#forgot_password_box').show();
		$('#login_box').hide();
	});


/*
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
*/

});