$(document).ready(function(){

	//var $invite = $('#msg_sendie').val();
	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	$('.pop_guest_login').click(function(){
		$('.pop_login').slideFadeToggle(function () {
			$('#login_box').show();
			$('#forgot_password_box').hide();
		});
	});

	$('.pop_guest_click').click(function(event){
		event.preventDefault();
		$('.pop_guest').slideFadeToggle(function(){
			$('#sign_up_box').show();
			$('#create_account').hide();
			$('#fb_or_email_guest').hide();
		});
		//return false;
	});

	$('.pop_reg').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
			$('#fb_or_email_guest').hide();
			//$('#login_box').show();
			//$('#forgot_password_box').hide();
		});
	});

	$('.pop_log').click(function(){
		$('.pop_login').slideFadeToggle(function() {
			$('#login_box').show();
			$('#forgot_password_box').hide();
		});
	});

	$('#register_side').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').hide();
			$('#fb_or_email_guest').show();
		});
	});

	$('#cancel_email_sign_up, #close').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
		});
	});


	$('button[name=sign_up]').click(function(){
		$('#sign_up_box').hide();
		$('#fb_or_email_guest').show();
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

});