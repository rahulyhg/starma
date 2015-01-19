$(document).ready(function(){

	//var $invite = $('#msg_sendie').val();
	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};
/*
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

*/
	$('.pop_fp_click').click(function(){
		//$('#create_account').hide();
		$('#forgot_password_box').hide();
		//$('#sign_up_box').show();
		$('#sending').html('');
		$('#close_fp').hide();
		$('.pop_fp').hide();
		$('#fp_email').val('');
		$('#fp_email').css('border', '1px solid #1a1d2a');
	});

	$('#login_email_landing').click(function(){
		$('.pop_login_landing').show();
		$('#login_email').focus();
		$('.pop_login_click').show();
		$('#login_box').show();
	});

	$('.pop_login_click').click(function(){
		$('.pop_login_landing').hide();
		$('#login_box').hide();
		$('#login_email').val('');
		$('#login_password').val('');
	});

	$('button[name=cancel]').click(function(){
		$('.pop_fp').slideFadeToggle(function() {
			//$('#landing_sign_up_box').show();
			$('#create_account').hide();
		});
	});

	//STARTS HERE
	/*
	$('#rocketship').click(function(){
		$('#sign_up_box').hide();
		$('#create_account').hide();
		$('#create_account_fb').hide();
		$('#login_box').show();
	});
	*/
	$('#sign_in_button').click(function(){
		$('#landing1').hide();
		$('#sign_up_or_sign_in').hide();
		$('#sign_up_box').hide();
		$('#create_account').hide();
		$('#create_account_fb').hide();
		$('#login_box').show();
	});

	$('#sign_up_button').click(function(){
		$('#sign_up_or_sign_in').hide();
		$('#sign_up_box').show();
		$('#create_account').hide();
		$('#create_account_fb').hide();
		$('#login_box').hide();
	});

	$('#cancel_login').click(function(){
		$('#login_box').hide();
		$('#sign_up_or_sign_in').show();
	});

	
	$('button[name=sign_up_email]').click(function(){
		$('#sign_up_box').hide();
		$('#create_account').show();
		//$('#username>input').focus();
	});

	$('#cancel_email_sign_up').click(function(){
		$('#create_account').hide();
		$('#sign_up_or_sign_in').show();
	});


	//$('button[name=sign_up_fb]').click(function(){
		//checkLoginState();	
		//$('#sign_up_box').hide();
		//$('#create_account_fb').show();
	//});

	$('#cancel_sign_up_fb').click(function(){
		$('#create_account_fb').hide();
		$('#sign_up_or_sign_in').show();
	});

	$('#cancel_sign_up').click(function(){
		$('#sign_up_box').hide();
		$('#sign_up_or_sign_in').show();
	});

	$('#forgot_password_landing').click(function(){
		$('.pop_fp').show();
		$('.pop_fp_click').show();
		$('#forgot_password_box').show();
		//$('.pop_login_landing').hide();
		//$('#login_box').hide();
		$('#login_email').val('');
		$('#login_password').val('');
	});

	$('#close_fp').click(function(){
		$('.pop_fp').slideFadeToggle(function(){
			$('#sending').html('');
			$('#close_fp').hide();
			$('#forgot_password_box').hide();
			$('#fp_email').val('');
			$('#fp_email').css('border', '1px solid #1a1d2a');
		});
	});

});