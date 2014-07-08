$(document).ready(function(){

	var timer;

	$('input[name=nickname]').keyup(function(){
		clearInterval(timer);
		timer = setTimeout(function() {
			var username = { 'username' : $('input[name=nickname]').val()};

			$.post('chat/register_form_fields.php', username, function(data){
				if(data.errors) {	
					$('#username_error').show().addClass('register_error').removeClass('check').text(data.message);
				}
				if(data.success) {
					$('#username_error').show().removeClass('register_error').addClass('check').text(data.message);
				}
			}, 'json');
		}, 1000);
	});

	$('input[name=email]').keyup(function(){
		clearInterval(timer);
		timer = setTimeout(function() {
			var email = { 'email' : $('input[name=email]').val()};

			$.post('chat/register_form_fields.php', email, function(data){
				if(data.errors) {	
					$('#email_error').show().addClass('register_error').removeClass('check').text(data.message);
				}
				if(data.success) {
					$('#email_error').show().removeClass('register_error').addClass('check').text(data.message);
				}
			}, 'json');
		}, 1000);
	});

	$('input[name=email2]').keyup(function(){
		clearInterval(timer);
		timer = setTimeout(function() {
			var email2 = $('input[name=email2]').val();
			var email = $('input[name=email]').val();
			if (email != email2) {
				$('#email2_error').show().addClass('register_error').removeClass('check').text('The two emails must match');
			}
			else {
				$('#email2_error').show().removeClass('register_error').addClass('check').text('All Good');
			}
		}, 1500);
	});
/*
	$('input[name=password]').focus(function(){
		var default_text = 'Your password must be between 6 and 15 characters, and include only letters, numbers, underscores (_), hyphens (-), !, @';
		$('#password_error').show().addClass('register_error').removeClass('check').text(default_text);
	});
*/
	$('input[name=password]').keyup(function(){
		clearInterval(timer);
		timer = setTimeout(function() {
			var password = { 'password' : $('input[name=password]').val()};
			$.post('chat/register_form_fields.php', password, function(data){
				//$('#password_error').show().addClass('register_error').removeClass('check').text(data);
				if(data.errors) {	
					$('#password_error').show().addClass('register_error').removeClass('check').text(data.message);
				}
				if(data.success) {
					$('#password_error').show().removeClass('register_error').addClass('check').text(data.message);
				}
			}, 'json');
		}, 1500);
	});


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

		})
		.fail(function(data){

		});

		event.preventDefault();

	});

});