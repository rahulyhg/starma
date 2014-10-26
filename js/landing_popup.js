$(document).ready(function(){

	//var $invite = $('#msg_sendie').val();
	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};
	/*
	$('.pop_landing_login').click(function(){
		$('.pop_login').slideFadeToggle();
	});

	$('.pop_landing_click').click(function(event){
		event.preventDefault();
		$('.pop_guest').slideFadeToggle();
		return false;
	});

	$('.pop_reg').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
		});
	});

	$('.pop_log').click(function(){
		$('.pop_login').slideFadeToggle();
	});
	*/

//A LITTLE UI ON THE SLY--------------------------------
	$('#go_bug_button').mouseenter(function() {
		$('#go_bug_path_landing').css('background-image', 'url(/img/goBugPathLandingON.png)');
	});

	$('#go_bug_button').mouseleave(function() {
		$('#go_bug_path_landing').css('background-image', 'url(/img/Starma-Astrology-go-bug-path.png)');
	});

	$('#feet_bug').mouseenter(function() {
		//$('#explore').css({'border-color':'#e7ebee', 'box-shadow' : '0 0 2px 0 #e7ebee inset'});
		$('#explore a').css('color', '#e7ebee');
	});

	$('#feet_bug').mouseleave(function() {
		//$('#explore').css({'border-color':'#1a1d2a', 'box-shadow':'0 0 2px 0 #1a1d2a inset'});
		$('#explore a').css('color', '#1a1d2a');
	});


	$('.pop_landing_click').click(function(){
		$('#create_account').hide();
		$('#forgot_password_box').hide();
		$('#sign_up_box').show();
		$('.pop_landing').hide();
		$('#fp_email').val('');
		$('#fp_email').css('border', '1px solid #1a1d2a');
	});

	$('button[name=cancel]').click(function(){
		$('.pop_landing').slideFadeToggle(function() {
			//$('#landing_sign_up_box').show();
			$('#create_account').hide();
		});
	});

	
	$('button[name=sign_up_email]').click(function(){
		$('#sign_up_box').hide();
		$('#create_account').show();
		//$('#username>input').focus();
	});
	
	$('#cancel_email_sign_up').click(function(){
		$('#sign_up_box').show();
		$('#create_account').hide();
	});

	$('#forgot_password_landing').click(function(){
		$('.pop_landing').show();
		$('.pop_landing_click').show();
		$('#forgot_password_box').show();
	});

});