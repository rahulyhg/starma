$(document).ready(function(){

	//var $invite = $('#msg_sendie').val();
	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	var generic_text = 'This part of the site is reserved for Starma members only. In order to view this content...';

	$('.pop_guest_login').click(function(){
		$('.pop_login').slideFadeToggle(function () {
			$('#login_box').show();
			$('#login_email').focus();
			$('#forgot_password_box').hide();
		});
	});

	$('.pop_log').click(function(){
		$('.pop_login').slideFadeToggle(function() {
			$('#login_box').show();
			$('#forgot_password_box').hide();
		});
	});

	$('.pop_guest_click').click(function(event){
		event.preventDefault();
		$('#sign_up_box_text').text(generic_text);
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

	$('#register_side, #register_top').click(function(){
		$('#sign_up_box').hide();
		$('#fb_or_email_guest').show();
		$('.pop_guest').slideFadeToggle();
	});

	$('#close').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			//$('#intro').hide();
			$('#create_account').hide();
			$('#fb_or_email_guest').hide();
		});
	});


	$('#create_an_account').click(function(){
		//$('#intro').hide();
		$('#sign_up_box').hide();
		$('#fb_or_email_guest').show();
	});


	$('button[name=cancel]').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').hide();
		});
	});

	$('button[name=sign_up_email]').click(function(){
		$('#fb_or_email_guest').hide();
		$('#create_account').show();
	});

	$('button[name=sign_up_fb]').click(function(){
		$('#fb_or_email_guest').hide();
		$('#create_account_fb').show();
	});

	$('#cancel_sign_up_fb').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account_fb').hide();
			$('#fb_or_email_guest').hide();
		});
	});

	
	$('#cancel_email_sign_up').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
			$('#fb_or_email_guest').hide();
		});
	});


	$('#forgot_password').click(function(){
		$('#forgot_password_box').show();
		$('#login_box').hide();
	});

//GENERIC POPUP BOX----------------------

/*

	$('.pop_guest_click_generic').click(function(event){
		event.preventDefault();
		$('.pop_guest').slideFadeToggle(function(){
			$('#sign_up_box').show();
			$('.sign_up_text').text(generic_text);
			$('#create_account').hide();
			$('#fb_or_email_guest').hide();
		});
		//return false;
	});

	$('.pop_reg').click(function(){
		$('.pop_guest_g').slideFadeToggle(function() {
			$('#generic_box').show();
			$('#create_account_g').hide();
			$('#fb_or_email_guest_g').hide();
			//$('#login_box').show();
			//$('#forgot_password_box').hide();
		});
	});

	$('#close_g').click(function(){
		$('.pop_guest_g').slideFadeToggle(function() {
			//$('#sign_up_box').show();
			$('#generic_box').hide();
			$('#create_account_g').hide();
			$('#fb_or_email_guest_g').hide();
		});
	});

	$('input[name=create_an_account_g]').click(function(){
		$('#generic_box').hide();
		//$('#sign_up_box').hide();
		$('#fb_or_email_guest_g').show();
	});

	$('button[name=sign_up_email_g]').click(function(){
		$('#fb_or_email_guest_g').hide();
		$('#create_account_g').show();
	});

	
	$('#cancel_email_sign_up_g').click(function(){
		$('.pop_guest_g').slideFadeToggle(function() {
			//$('#sign_up_box').show();
			$('#generic_box').show();
			$('#create_account_g').hide();
			$('#fb_or_email_guest_g').hide();
		});
	});
*/

});