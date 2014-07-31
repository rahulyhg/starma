$(document).ready(function(){

	// GUEST VIEW FILE
	// I MAY NOT BE ABLE TO TIE REGISTERING AND LOGGING IN FROM GUEST
	// AND REG AND LOGIN FROM LANDING TOGETHER
	// SO I MAY NEED SEPARATE FUNCTION CALLS

	var timer_username;
	var timer_email;
	var timer_email2;
	var timer_password;

	$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
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
		var email_error2 = $('#reg_email2_error');
		var pass = $('#reg_password_error');
		clearInterval(timer_username);
		timer_username = setTimeout(function() {
			var username = { 'username' : $('#register_username').val()};

			$.post('../chat/register_form_fields.php', username, function(data){
				if(data.errors) {	
					$('#reg_username_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
					$('#register_username').addClass('red_border');
				}
				if(data.success) {
					$('#reg_username_error').show().removeClass('register_error').addClass('check').text('');
					$('#register_username').removeClass('red_border');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		}, 800);
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
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#reg_birthday_error').show().removeClass('register_error').addClass('check').text('');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
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
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#reg_email_error').show().removeClass('register_error').addClass('check').text('');
					if(email_error1.hasClass('check') && (email1 == email2)) { 
						$('#reg_email2_error').show().removeClass('register_error').addClass('check').text('');
					}
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		}, 800);
	});

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
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text(data.message);
					$('#register_submit').css({
												'opacity' : 0.5,
												'cursor'  : 'default'
												});
				}
				if(data.success) {
					$('#reg_password_error').show().removeClass('register_error').addClass('check').text('');
					if (name.hasClass('check') && age.hasClass('check') && email_error1.hasClass('check') && email_error2.hasClass('check') && pass.hasClass('check')) {
						//if ($('input[name=agreement]').is(':checked')) {
							$('#register_submit').css({
																'opacity' : 1,
																'cursor'  : 'pointer'
															});
						//}
					}
				}
			}, 'json');
		}, 800);

	});

	
	//Post 
	$('#register_form').submit(function(event){

		var data = {
			'username'        :  $('#register_username').val(),
			'year_birthday'   :  $('#year').val(),
			'month_birthday'  :  $('#month').val(),
			'day_birthday'    :  $('#day').val(),
			'email'           :  $('#register_email').val(),
			'email2'          :  $('#register_email2').val(),
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
					$('#reg_username_error').show().addClass('register_error').removeClass('check').text(data.errors.username);
				}
				if (data.errors.strtotime) {
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text(data.errors.strtotime);
				}
				if (data.errors.underage) {
					$('#reg_birthday_error').show().addClass('register_error').removeClass('check').text(data.errors.underage);
				}
				if (data.errors.email_match) {
					$('#reg_email2_error').show().addClass('register_error').removeClass('check').text(data.errors.email_match);
				}
				if (data.errors.email_valid) {
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text(data.errors.email_valid);
				}
				if (data.errors.email_empty) {
					$('#reg_email_error').show().addClass('register_error').removeClass('check').text(data.errors.email_empty);
				}
				if(data.errors.pass_empty) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text(data.errors.pass_empty);
				}
				if(data.errors.pass_short) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text(data.errors.pass_short);
				}
				if(data.errors.pass_long) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text(data.errors.pass_long);
				}
				if(data.errors.characters) {
					$('#reg_password_error').show().addClass('register_error').removeClass('check').text(data.errors.characters);
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
				if (data.failed.email2) {
					alert(data.failed.email2);
					//$('#reg_email2_error').show().addClass('register_error').removeClass('check').text(data.failed.email2);
				}
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