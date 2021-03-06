$(document).ready(function(){

	// GUEST VIEW FILE
	// I MAY NOT BE ABLE TO TIE REGISTERING AND LOGGING IN FROM GUEST
	// AND REG AND LOGIN FROM LANDING TOGETHER
	// SO I MAY NEED SEPARATE FUNCTION CALLS

	var timer_username;
	var timer_email;
	//var timer_email2;
	var timer_password;

	$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});

//--------------------SHOWING ERROR EXP
	$('#reg_username_error').mouseenter(function(){
		$('#reg_err_username_exp_g').show();
	});
	$('#reg_username_error').mouseleave(function(){
		$('#reg_err_username_exp_g').hide();
	});
	$('#reg_birthday_error').mouseenter(function(){
		$('#reg_err_birthday_exp_g').show();
	});
	$('#reg_birthday_error').mouseleave(function(){
		$('#reg_err_birthday_exp_g').hide();
	});
	$('#reg_email_error').mouseenter(function(){
		$('#reg_err_email_exp_g').show();
	});
	$('#reg_email_error').mouseleave(function(){
		$('#reg_err_email_exp_g').hide();
	});
	$('#reg_password_error').mouseenter(function(){
		$('#reg_err_password_exp_g').show();
	});
	$('#reg_password_error').mouseleave(function(){
		$('#reg_err_password_exp_g').hide();
	});




//-------------------------QUICK CHECKS OF FIELDS ON BLUR AND KEYUP 
	//Username
	$('#register_username').on('keyup blur', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_username);
		timer_username = setTimeout(function() {
			var username = { 'username' : $('#register_username').val()};

			$.post('../chat/register_form_fields.php', username, function(data){
				if(data.errors) {	
					$('#reg_username_error').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');
      				$('#reg_username_check').css('display', 'none').removeClass('check').text('');
					$('#register_username').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_username_exp_g').text(data.message);
				}
				if(data.success) {
					$('#reg_username_error').css('display', 'none').removeClass('register_error').addClass('check').text('');        
					$('#reg_username_check').css('display', 'inline-block').addClass('check').text(data.message);
					$('#register_username').css('border', '1px solid black');
					$('#reg_username_check').show().text(data.message);
					$('#reg_err_username_exp_g').hide();
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		}, 2000);
	});

	//Birthday
	$('#year').on('change blur', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		//clearInterval(timer);
		//timer = setTimeout(function() {
			var birthday = { 'year_birthday'  : $('#year').val(),
							 'month_birthday' : $('#month').val(),
							 'day_birthday'   : $('#day').val()
							};

			$.post('../chat/register_form_fields.php', birthday, function(data){
				if(data.errors) {	
					$('#reg_birthday_error').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');                      
                    $('#reg_birthday_check').css('display', 'none').removeClass('check').text('');
					$('#year').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_birthday_exp_g').text(data.message);
				}
				if(data.success) {
					$('#reg_birthday_error').css('display', 'none').removeClass('register_error').addClass('check').text('');
					$('#reg_birthday_check').css('display', 'inline-block').addClass('check').text(data.message);
					$('#year').css('border', '1px solid black');
					$('#reg_birthday_check').show().text(data.message);
					$('#reg_err_birthday_exp_g').hide();
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		//}, 100);
	});

	//Email1
	$('#register_email').on('keyup blur', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_email);
		var email1 = $('#register_email').val();
		var email2 = $('#register_email2').val();
		timer_email = setTimeout(function() {
			var email = { 'email' : $('#register_email').val()};

			$.post('../chat/register_form_fields.php', email, function(data){
				if(data.errors) {	
					$('#reg_email_error').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');                      
                    $('#reg_email_check').css('display', 'none').removeClass('check').text('');
					$('#register_email').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_email_exp_g').text(data.message);
				}
				if(data.success) {
					$('#reg_email_error').css('display', 'none').removeClass('register_error').addClass('check').text('');
					$('#reg_email_check').css('display', 'inline-block').addClass('check').text(data.message);
					$('#register_email').css('border', '1px solid black');
					$('#reg_email_check').show().text(data.message);
					$('#reg_err_email_exp_g').hide();
					//if(email_error1.hasClass('check') && (email1 == email2)) { 
					//	$('#reg_email2_error').show().removeClass('register_error').addClass('check').text('');
					//}
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		}, 2000);
	});

/*
	//Email2
	$('#register_email2').on('keyup blur focus', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_email2);
		var email = $('#register_email').val();
		var email2 = $('#register_email2').val();
		timer_email2 = setTimeout(function() {
			
			if (!(email == email2)) {
				$('#reg_email2_error').show().addClass('register_error').removeClass('check').text('The two emails must match');
				$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
			}
			if (email == '') {
				$('#reg_email_error').show().addClass('register_error').removeClass('check').text('Please enter a valid email');
				$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
			}
			if(email_error1.hasClass('check') && (email == email2)) { 
				$('#reg_email2_error').show().removeClass('register_error').addClass('check').text('');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
			}
		}, 1200);
	});

*/

	//Password
	$('#register_password').on('keyup blur', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_password);
		timer_password = setTimeout(function() {
			var password = { 'password' : $('#register_password').val()};
			$.post('../chat/register_form_fields.php', password, function(data){
				//$('#password_error').show().addClass('register_error').removeClass('check').text(data);
				if(data.errors) {	
					$('#reg_password_error').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');                      
                    $('#reg_password_check').css('display', 'none').removeClass('check').text('');
					$('#register_password').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_password_exp_g').text(data.message);
				}
				if(data.success) {
					$('#reg_password_error').css('display', 'none').removeClass('register_error').addClass('check').text('');
					$('#reg_password_check').css('display', 'inline-block').addClass('check').text(data.message);
					$('#register_password').css('border', '1px solid black');
					$('#reg_password_check').show().text(data.message);
					$('#reg_err_password_exp_g').hide();
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		}, 2000);

	});

	
	//Post 
	$('#register_form').submit(function(event){

		var data = {
			'username'        :  $('#register_username').val(),
			'year_birthday'   :  $('#year').val(),
			'month_birthday'  :  $('#month').val(),
			'day_birthday'    :  $('#day').val(),
			'email'           :  $('#register_email').val(),
			'password'        :  $('#register_password').val(),
		};

		$.ajax({
			type      : 'POST',
			url       : '../chat/register_user.php',
			data      : data,
			dataType  : 'json',
		})
		.done(function(data){
			//alert(data);
			
			if (data.errors) {
				if (data.errors.username) {
					$('#reg_username_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_username_exp_g').text(data.errors.username);
					$('#register_username').css('border', '1px solid #C82923');
				}
				if (data.errors.strtotime) {
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_birthday_exp_g').text(data.errors.strtotime);
					$('#year').css('border', '1px solid #C82923');
				}
				if (data.errors.underage) {
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_birthday_exp_g').text(data.errors.underage);
					$('#year').css('border', '1px solid #C82923');
				}
				//if (data.errors.email_match) {
				//	$('#reg_email2_error').show().addClass('register_error').removeClass('check').text(data.errors.email_match);
				//}
				if (data.errors.email_valid) {
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_email_exp_g').text(data.errors.email_valid);
					$('#register_email').css('border', '1px solid #C82923');
				}
				if (data.errors.email_empty) {
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_email_exp_g').text(data.errors.email_empty);
					$('#register_email').css('border', '1px solid #C82923');
				}
				if(data.errors.pass_empty) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_password_exp_g').text(data.errors.pass_empty);
					$('#register_password').css('border', '1px solid #C82923');
				}
				if(data.errors.pass_short) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_password_exp_g').text(data.errors.pass_short);
					$('#register_password').css('border', '1px solid #C82923');
				}
				if(data.errors.pass_long) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_password_exp_g').text(data.errors.pass_long);
					$('#register_password').css('border', '1px solid #C82923');
				}
				if(data.errors.characters) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
					$('#reg_err_password_exp_g').text(data.errors.characters);
					$('#register_password').css('border', '1px solid #C82923');
				}
			}
			if (data.failed) {
				if (data.failed.username) {
					alert(data.failed.username);
					//$('#reg_username_error').show().addClass('register_error').removeClass('check').text(data.failed.username);
				}
				if (data.failed.underage) {
					alert(data.failed.underage);
					//$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text(data.failed.underage);
				}
				if (data.failed.strtotime) {
					alert(data.failed.strtotime);
					//$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text(data.failed.strtotime);
				}
				//if (data.failed.email2) {
				//	alert(data.failed.email2);
					//$('#reg_email2_error').show().addClass('register_error').removeClass('check').text(data.failed.email2);
				//}
				if (data.failed.email) {
					alert(data.failed.email);
					//$('#reg_email_error').show().addClass('register_error').removeClass('check').text(data.failed.email);
				}
				if(data.failed.password) {
					alert(data.failed.password);
					//$('#reg_password_error').show().addClass('register_error').removeClass('check').text(data.failed.password);
				}
				if(data.failed.user_exists) {
					alert(data.failed.user_exists);
					//$('#reg_user_exists').show().addClass('register_error').removeClass('check').text(data.failed.user_exists);
				}
			}
			if (data.url) {
				//alert(data.url);
				mixpanel.track('Email Create Account Guest', {}, window.location.assign('../' + data.url));
				//window.location.assign('/' + data.url);
				setTimeout(function(){ window.location.assign('../' + data.url); }, 500);
				//window.location.assign('../' + data.url);
			}
			if (!data) {
				alert('There was an ajax error, please try again');
			}
			
		});
		//.fail(function(data){

		//});

		event.preventDefault();

	});



//FB REGISTER
	
	var timer_username_fb;
	var timer_email_fb;


	$('#reg_username_error_fb').mouseenter(function(){
		$('#reg_err_username_exp_fb_g').show();
	});
	$('#reg_username_error_fb').mouseleave(function(){
		$('#reg_err_username_exp_fb_g').hide();
	});
	$('#reg_birthday_error_fb').mouseenter(function(){
		$('#reg_err_birthday_exp_fb_g').show();
	});
	$('#reg_birthday_error_fb').mouseleave(function(){
		$('#reg_err_birthday_exp_fb_g').hide();
	});
	$('#reg_email_error_fb').mouseenter(function(){
		$('#reg_err_email_exp_fb_g').show();
	});
	$('#reg_email_error_fb').mouseleave(function(){
		$('#reg_err_email_exp_fb_g').hide();
	});

	
	$('#register_form_fb').submit(function(event){

		var data_fb = {
			'fb' 				 :  'fb',
			'username_fb'        :  $('#register_username_fb').val(),
			'year_birthday_fb'   :  $('#year_fb').val(),
			'month_birthday_fb'  :  $('#month_fb').val(),
			'day_birthday_fb'    :  $('#day_fb').val(),
			'email_fb'           :  $('#register_email_fb').val(),
		};

		$.ajax({
			type      : 'POST',
			url       : '../chat/register_user.php',
			data      : data_fb,
			dataType  : 'json',
		})
		.done(function(data){
			//alert(data);
			
			if (data.errors) {
				if (data.errors.username_fb) {
					$('#reg_err_username_exp_fb_g').text(data.errors.username_fb);
					$('#register_username_fb').css('border', '1px solid #C82923');
					$('#reg_username_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.strtotime_fb) {
					$('#reg_err_birthday_exp_fb_g').text(data.errors.strtotime);
					$('#year_fb').css('border', '1px solid #C82923');
					$('#reg_birthday_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.underage_fb) {
					$('#reg_err_birthday_exp_fb_g').text(data.errors.underage_fb);
					$('#year_fb').css('border', '1px solid #C82923');
					$('#reg_birthday_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.email_valid_fb) {
					$('#reg_err_email_exp_fb_g').text(data.errors.email_valid_fb);
					$('#register_email_fb').css('border', '1px solid #C82923');
					$('#reg_email_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.email_empty_fb) {
					$('#reg_err_email_exp_fb_g').text(data.errors.email_empty_fb);
					$('#register_email_fb').css('border', '1px solid #C82923');
					$('#reg_email_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.fb_id) {
					alert(data.errors.fb_id);
				}
			}
			if (data.failed) {
				if (data.failed.username_fb) {
					alert(data.failed.username_fb);
				}
				if (data.failed.underage_fb) {
					alert(data.failed.underage_fb);
				}
				if (data.failed.strtotime_fb) {
					alert(data.failed.strtotime_fb);
				}
				if (data.failed.email_fb) {
					alert(data.failed.email_fb);
				}
				if(data.failed.user_exists_fb) {
					alert(data.failed.user_exists_fb);
				}
			}
			if (data.url_fb) {
				mixpanel.track('FB Create Account Guest', {}, window.location.assign('../' + data.url_fb));
				setTimeout(function(){ window.location.assign('/' + data.url_fb); }, 500);
				//alert(data.url);
				//window.location.assign('../' + data.url_fb);
			}
			if (!data) {
				alert('There was an ajax error with Facebook, please try again');
			}
			
		});

		event.preventDefault();

	});
		


	//Username
	$('#register_username_fb').on('keyup blur', function(){
		var name = $('#reg_username_error_fb');
		var age = $('#reg_birthday_error_fb');
		var email_error1 = $('#reg_email_error_fb');
		clearInterval(timer_username);
		timer_username_fb = setTimeout(function() {
			var username_fb = { 'username' : $('#register_username_fb').val()};

			$.post('../chat/register_form_fields.php', username_fb, function(data){
				if(data.errors) {	
					$('#reg_username_error_fb').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');                      
                    $('#reg_username_check_fb').css('display', 'none').removeClass('check').text('');
					$('#register_username_fb').css('border', '1px solid #C82923');
					$('#register_submit_fb').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_username_exp_fb_g').text(data.message);
					
				}
				if(data.success) {
					$('#reg_username_error_fb').css('display', 'none').removeClass('register_error').addClass('check').text('');
					$('#reg_username_check_fb').css('display', 'inline-block').addClass('check').text(data.message);
					$('#reg_err_username_exp_fb_g').hide();
					$('#register_username_fb').css('border', '1px solid black');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check')) {
							$('#register_submit_fb').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
					}
				}
			}, 'json');
		}, 2000);
	});

	//Birthday
	$('#year_fb').on('change blur', function(){
		var name = $('#reg_username_error_fb');
		var age = $('#reg_birthday_error_fb');
		var email_error1 = $('#reg_email_error_fb');
			var birthday_fb = { 'year_birthday'  : $('#year_fb').val(),
							 	'month_birthday' : $('#month_fb').val(),
							 	'day_birthday'   : $('#day_fb').val()
								};

			$.post('../chat/register_form_fields.php', birthday_fb, function(data){
				if(data.errors) {	
					$('#reg_birthday_error_fb').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');                      
                    $('#reg_birthday_check_fb').css('display', 'none').removeClass('check').text('');

					$('#year_fb').css('border', '1px solid #C82923');
					$('#register_submit_fb').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_birthday_exp_fb_g').text(data.message);
				}
				if(data.success) {
					$('#reg_birthday_error_fb').css('display', 'none').removeClass('register_error').addClass('check').text('');
					$('#reg_birthday_check_fb').css('display', 'inline-block').addClass('check').text(data.message);

					$('#reg_err_birthday_exp_fb_g').hide();
					$('#year_fb').css('border', '1px solid black');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check')) {
							$('#register_submit_fb').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
					}
				}
			}, 'json');
	});

	//Email1
	$('#register_email_fb').on('keyup blur', function(){
		var name = $('#reg_username_error_fb');
		var age = $('#reg_birthday_error_fb');
		var email_error1 = $('#reg_email_error_fb');
		clearInterval(timer_email_fb);
		var email_fb = $('#register_email_fb').val();
		timer_email_fb = setTimeout(function() {
			var email_fb = { 'email' : $('#register_email_fb').val()};

			$.post('../chat/register_form_fields.php', email_fb, function(data){
				if(data.errors) {	
					$('#reg_email_error_fb').css('display', 'inline-block').addClass('register_error').removeClass('check').text('?');                      
                    $('#reg_email_check_fb').css('display', 'none').removeClass('check').text('');

					$('#register_email_fb').css('border', '1px solid #C82923');
					$('#register_submit_fb').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_email_exp_fb_g').text(data.message);
				}
				if(data.success) {
					$('#reg_email_error_fb').css('display', 'none').removeClass('register_error').addClass('check').text('');
					$('#reg_email_check_fb').css('display', 'inline-block').addClass('check').text(data.message);

					$('#reg_err_email_exp_fb_g').hide();
					$('#register_email_fb').css('border', '1px solid black');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check')) {
							$('#register_submit_fb').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
					}
				}
			}, 'json');
		}, 2000);
	});




	/*

	$('input[name=nickname]').focus();

	var timer_username;
	var timer_email;
	var timer_email2;
	var timer_password;

	$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
	//Username
	$('input[name=nickname]').on('keyup blur', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		clearInterval(timer_username);
		timer_username = setTimeout(function() {
			var username = { 'username' : $('input[name=nickname]').val()};

			$.post('chat/register_form_fields.php', username, function(data){
				if(data.errors) {	
					$('#username_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#username_error').show().removeClass('register_error').addClass('check').text(data.message);
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						if ($('input[name=agreement]').is(':checked')) {
							$('#bug_button').prop('disabled', false).css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						}
					}
				}
			}, 'json');
		}, 500);
	});

	//Birthday
	$('#year').on('change blur', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		//clearInterval(timer);
		//timer = setTimeout(function() {
			var birthday = { 'year_birthday'  : $('#year').val(),
							 'month_birthday' : $('#month').val(),
							 'day_birthday'   : $('#day').val()
							};

			$.post('chat/register_form_fields.php', birthday, function(data){
				if(data.errors) {	
					$('#underage_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#underage_error').show().removeClass('register_error').addClass('check').text(data.message);
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						if ($('input[name=agreement]').is(':checked')) {
							$('#bug_button').prop('disabled', false).css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						}
					}
				}
			}, 'json');
		//}, 100);
	});

	//Email1
	$('input[name=email]').on('keyup blur', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		clearInterval(timer_email);
		var email1 = $('input[name=email]').val();
		var email2 = $('input[name=email2]').val();
		timer_email = setTimeout(function() {
			var email = { 'email' : $('input[name=email]').val()};

			$.post('chat/register_form_fields.php', email, function(data){
				if(data.errors) {	
					$('#email_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#email_error').show().removeClass('register_error').addClass('check').text(data.message);
					if(email_error1.hasClass('check') && (email1 == email2)) { 
						$('#email2_error').show().removeClass('register_error').addClass('check').text('Great!');
					}
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						if ($('input[name=agreement]').is(':checked')) {
							$('#bug_button').prop('disabled', false).css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						}
					}
				}
			}, 'json');
		}, 100);
	});

	//Email2
	$('input[name=email2]').on('keyup blur focus', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		clearInterval(timer_email2);
		var email = $('input[name=email]').val();
		var email2 = $('input[name=email2]').val();
		timer_email2 = setTimeout(function() {
			
			if (!(email == email2)) {
				$('#email2_error').show().addClass('register_error').removeClass('check').text('The two emails must match');
				$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
			}
			if (email == '') {
				$('#email_error').show().addClass('register_error').removeClass('check').text('Please enter a valid email');
				$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
			}
			if(email_error1.hasClass('check') && (email == email2)) { 
				$('#email2_error').show().removeClass('register_error').addClass('check').text('Great!');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						if ($('input[name=agreement]').is(':checked')) {
							$('#bug_button').prop('disabled', false).css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						}
					}
			}
		}, 100);
	});

	//Password
	$('input[name=password]').on('keyup blur', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		clearInterval(timer_password);
		timer_password = setTimeout(function() {
			var password = { 'password' : $('input[name=password]').val()};
			$.post('chat/register_form_fields.php', password, function(data){
				//$('#password_error').show().addClass('register_error').removeClass('check').text(data);
				if(data.errors) {	
					$('#password_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#password_error').show().removeClass('register_error').addClass('check').text(data.message);
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						if ($('input[name=agreement]').is(':checked')) {
							$('#bug_button').prop('disabled', false).css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						}
					}
				}
			}, 'json');
		}, 300);

	});

	//Agreement
	$('input[name=agreement]').on('change', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		var agreement = $('input[name=agreement]');

		if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check') && agreement.is(':checked')) {
				$('#bug_button').prop('disabled', false).css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
		}
		else {
			$('#bug_button').prop('disabled', true).css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
		}
	});

	//Post 
	$('form[name=register_form]').submit(function(event){

		var data = {
			'username'        :  $('input[name=nickname]').val(),
			'year_birthday'   :  $('select[name=year_birthday]').val(),
			'month_birthday'  :  $('select[name=month_birthday]').val(),
			'day_birthday'    :  $('select[name=day_birthday]').val(),
			'email'           :  $('input[name=email]').val(),
			'email2'          :  $('input[name=email2]').val(),
			'password'        :  $('input[name=password]').val(),
			'agreement'       :  $('input[name=agreement]').val()
		};

		$.ajax({
			type      : 'POST',
			url       : 'chat/register_user.php',
			data      : data,
			dataType  : 'json'
		})
		.done(function(data){
			if (data.errors) {
				if (data.errors.agreement) {
					$('#terms_error').show().addClass('register_error').removeClass('check').text(data.agreement);
				}
				if(data.errors.underage) {
					$('#underage_error').show().addClass('register_error').removeClass('check').text(data.underage);
				}
			}
			if (data.failed) {
				$('#username_error').show().addClass('register_error').removeClass('check').text(data.failed);
			}

		})
		.fail(function(data){

		});

		event.preventDefault();

	});
	*/

});