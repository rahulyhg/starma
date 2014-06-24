$(document).ready(function(){

	var timer;

	$('input[name=nickname]').keyup(function(){
		clearInterval(timer);
		timer = setTimeout(function() {
			var username = { 'username' : $('input[name=nickname]').val()};

			$.post('chat/username_test.php', username, function(data){
				if(data.errors) {	
					$('#username_error').show().addClass('register_error').removeClass('check').text(data.message);
				}
				if(data.success) {
					$('#username_error').show().removeClass('register_error').addClass('check').text(data.message);
				}
			}, 'json');
		}, 1000);
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
			}

		})
		.fail(function(data){

		});

		event.preventDefault();

	});

});