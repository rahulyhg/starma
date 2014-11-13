$(document).ready(function(){


var timer_username;
	var timer_email;
	var timer_email2;
	var timer_password;

	$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});

		$('#reg_username_error').mouseenter(function(){
			$('#reg_err_username_exp').show();
		});
		$('#reg_username_error').mouseleave(function(){
			$('#reg_err_username_exp').hide();
		});
		$('#reg_birthday_error').mouseenter(function(){
			$('#reg_err_birthday_exp').show();
		});
		$('#reg_birthday_error').mouseleave(function(){
			$('#reg_err_birthday_exp').hide();
		});
		$('#reg_email_error').mouseenter(function(){
			$('#reg_err_email_exp').show();
		});
		$('#reg_email_error').mouseleave(function(){
			$('#reg_err_email_exp').hide();
		});
		$('#reg_password_error').mouseenter(function(){
			$('#reg_err_password_exp').show();
		});
		$('#reg_password_error').mouseleave(function(){
			$('#reg_err_password_exp').hide();
		});

/*
	$('#register_submit').click(function(event){
		if ($('#register_submit').prop('disabled', true)) {
			event.preventDefault();
			//$('.register_error').addClass('error_submitted', 500);
			alert('please fill out the form');
		}
	});
	*/

	//Username
	$('#register_username').on('keyup blur', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		//var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_username);
		timer_username = setTimeout(function() {
			var username = { 'username' : $('#register_username').val()};

			$.post('/chat/register_form_fields.php', username, function(data){
				if(data.errors) {	
					$('#reg_username_error').show().addClass('register_error').removeClass('check').text('?');
					$('#register_username').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_username_exp').text(data.message);
					
				}
				if(data.success) {
					$('#reg_username_error').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_username_check').show().text(data.message);
					$('#reg_err_username_exp').hide();
					$('#register_username').css('border', '1px solid black');
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
		//var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		//clearInterval(timer);
		//timer = setTimeout(function() {
			var birthday = { 'year_birthday'  : $('#year').val(),
							 'month_birthday' : $('#month').val(),
							 'day_birthday'   : $('#day').val()
							};

			$.post('/chat/register_form_fields.php', birthday, function(data){
				if(data.errors) {	
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text('?');
					$('#year').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_birthday_exp').text(data.message);
				}
				if(data.success) {
					$('#reg_birthday_error').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_birthday_check').show().text(data.message);
					$('#reg_err_birthday_exp').hide();
					$('#year').css('border', '1px solid black');
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
		//var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_email);
		var email1 = $('#register_email').val();
		var email2 = $('#register_email2').val();
		timer_email = setTimeout(function() {
			var email = { 'email' : $('#register_email').val()};

			$.post('/chat/register_form_fields.php', email, function(data){
				if(data.errors) {	
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text('?');
					$('#register_email').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_email_exp').text(data.message);
				}
				if(data.success) {
					$('#reg_email_error').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_email_check').show().text(data.message);
					$('#reg_err_email_exp').hide();
					$('#register_email').css('border', '1px solid black');
					//if(email_error1.hasClass('check')) { 
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


	//Password
	$('#register_password').on('keyup blur', function(){
		var name = $('#reg_username_error');
		var age = $('#reg_birthday_error');
		var email_error1 = $('#reg_email_error');
		//var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_password);
		timer_password = setTimeout(function() {
			var password = { 'password' : $('#register_password').val()};
			$.post('/chat/register_form_fields.php', password, function(data){
				//$('#password_error').show().addClass('register_error').removeClass('check').text(data);
				if(data.errors) {	
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
					$('#register_password').css('border', '1px solid #C82923');
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_password_exp').text(data.message);
				}
				if(data.success) {
					$('#reg_password_error').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_password_check').show().text(data.message);
					$('#reg_err_password_exp').hide();
					$('#register_password').css('border', '1px solid black');
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
			url       : '/chat/register_user.php',
			data      : data,
			dataType  : 'json',
		})
		.done(function(data){
			//alert(data);
			
			if (data.errors) {
				if (data.errors.username) {
					$('#reg_err_username_exp').text(data.errors.username);
					$('#register_username').css('border', '1px solid #C82923');
					$('#reg_username_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.strtotime) {
					$('#reg_err_birthday_exp').text(data.errors.strtotime);
					$('#year').css('border', '1px solid #C82923');
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.underage) {
					$('#reg_err_birthday_exp').text(data.errors.underage);
					$('#year').css('border', '1px solid #C82923');
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text('?');
				}
				//if (data.errors.email_match) {
				//	$('#reg_email2_error').show().addClass('register_error').removeClass('check').text(data.errors.email_match);
				//}
				if (data.errors.email_valid) {
					$('#reg_err_email_exp').text(data.errors.email_valid);
					$('#register_email').css('border', '1px solid #C82923');
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.email_empty) {
					$('#reg_err_email_exp').text(data.errors.email_empty);
					$('#register_email').css('border', '1px solid #C82923');
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if(data.errors.pass_empty) {
					$('#reg_err_password_exp').text(data.errors.pass_empty);
					$('#register_password').css('border', '1px solid #C82923');
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if(data.errors.pass_short) {
					$('#reg_err_password_exp').text(data.errors.pass_short);
					$('#register_password').css('border', '1px solid #C82923');
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if(data.errors.pass_long) {
					$('#reg_err_password_exp').text(data.errors.pass_long);
					$('#register_password').css('border', '1px solid #C82923');
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
				}
				if(data.errors.characters) {
					$('#reg_err_password_exp').text(data.errors.characters);
					$('#register_password').css('border', '1px solid #C82923');
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text('?');
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
				window.location.assign('../' + data.url);
			}
			if (!data) {
				alert('There was an ajax error, please try again');
			}
			
		});
		//.fail(function(data){

		//});

		event.preventDefault();

	});





//FACEBOOK --------------------------------------------------------------------------------

	var timer_username_fb;
	var timer_email_fb;

	$('#fb_register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});

		$('#reg_username_error_fb').mouseenter(function(){
			$('#reg_err_username_exp_fb').show();
		});
		$('#reg_username_error_fb').mouseleave(function(){
			$('#reg_err_username_exp_fb').hide();
		});
		$('#reg_birthday_error_fb').mouseenter(function(){
			$('#reg_err_birthday_exp_fb').show();
		});
		$('#reg_birthday_error_fb').mouseleave(function(){
			$('#reg_err_birthday_exp_fb').hide();
		});
		$('#reg_email_error_fb').mouseenter(function(){
			$('#reg_err_email_exp_fb').show();
		});
		$('#reg_email_error_fb').mouseleave(function(){
			$('#reg_err_email_exp_fb').hide();
		});


	//Username
	$('#register_username_fb').on('keyup blur', function(){
		var name = $('#reg_username_error_fb');
		var age = $('#reg_birthday_error_fb');
		var email_error1 = $('#reg_email_error_fb');
		clearInterval(timer_username);
		timer_username_fb = setTimeout(function() {
			var username_fb = { 'username' : $('#register_username_fb').val()};

			$.post('/chat/register_form_fields.php', username_fb, function(data){
				if(data.errors) {	
					$('#reg_username_error_fb').show().addClass('register_error').removeClass('check').text('?');
					$('#register_username_fb').css('border', '1px solid #C82923');
					$('#register_submit_fb').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_username_exp_fb').text(data.message);
					
				}
				if(data.success) {
					$('#reg_username_error_fb').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_username_check_fb').show().text(data.message);
					$('#reg_err_username_exp_fb').hide();
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

			$.post('/chat/register_form_fields.php', birthday_fb, function(data){
				if(data.errors) {	
					$('#reg_birthday_error_fb').show().addClass('register_error').removeClass('check').text('?');
					$('#year').css('border', '1px solid #C82923');
					$('#register_submit_fb').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_birthday_exp_fb').text(data.message);
				}
				if(data.success) {
					$('#reg_birthday_error_fb').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_birthday_check_fb').show().text(data.message);
					$('#reg_err_birthday_exp_fb').hide();
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

			$.post('/chat/register_form_fields.php', email_fb, function(data){
				if(data.errors) {	
					$('#reg_email_error_fb').show().addClass('register_error').removeClass('check').text('?');
					$('#register_email_fb').css('border', '1px solid #C82923');
					$('#register_submit_fb').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#reg_err_email_exp_fb').text(data.message);
				}
				if(data.success) {
					$('#reg_email_error_fb').hide().removeClass('register_error').addClass('check').text('');
					$('#reg_email_check_fb').show().text(data.message);
					$('#reg_err_email_exp_fb').hide();
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


	
	//Post 
	$('#r_form_fb').submit(function(event){

		var data_fb = {
			'fb' 				 :  'fb',
			'username_fb'        :  $('#register_username_fb').val(),
			'year_birthday_fb'   :  $('#year_fb').val(),
			'month_birthday_fb'  :  $('#month_fb').val(),
			'day_birthday_fb'    :  $('#day_fb').val(),
			'email_fb'           :  $('#register_email_fb').val(),
			'password_fb'        :  $('#register_password_fb').val(),
		};

		$.ajax({
			type      : 'POST',
			url       : '/chat/register_user.php',
			data      : data_fb,
			dataType  : 'json',
		})
		.done(function(data){
			//alert(data);
			
			if (data.errors) {
				if (data.errors.username_fb) {
					$('#reg_err_username_exp_fb').text(data.errors.username_fb);
					$('#register_username_fb').css('border', '1px solid #C82923');
					$('#reg_username_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.strtotime_fb) {
					$('#reg_err_birthday_exp_fb').text(data.errors.strtotime);
					$('#year_fb').css('border', '1px solid #C82923');
					$('#reg_birthday_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.underage_fb) {
					$('#reg_err_birthday_ex_fbp').text(data.errors.underage_fb);
					$('#year_fb').css('border', '1px solid #C82923');
					$('#reg_birthday_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.email_valid_fb) {
					$('#reg_err_email_exp_fb').text(data.errors.email_valid_fb);
					$('#register_email_fb').css('border', '1px solid #C82923');
					$('#reg_email_error_fb').show().addClass('register_error').removeClass('check').text('?');
				}
				if (data.errors.email_empty_fb) {
					$('#reg_err_email_exp_fb').text(data.errors.email_empty_fb);
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
				//alert(data.url);
				window.location.assign('../' + data.url_fb);
			}
			if (!data) {
				alert('There was an ajax error with Facebook, please try again');
			}
			
		});

		event.preventDefault();

	});

});