$(document).ready(function(){

	$('input[name=nickname]').focus();

	var timer_username;
	var timer_age;
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
		}, 800);
	});

	//Birthday
	$('#year').on('change blur', function(){
		var name = $('#username_error');
		var age = $('#underage_error');
		var email_error1 = $('#email_error');
		var email_error2 = $('#email2_error');
		var pass = $('#password_error');
		clearInterval(timer_age);
		timer_age = setTimeout(function() {
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
		}, 400);
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
		}, 2000);
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
		}, 2000);
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
		}, 2000);

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

	/*//Post 
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