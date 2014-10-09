$(document).ready(function(){
	/*
	$('#pass').on('focus', function(){
		$(this).toggle();
		$('#login_password').toggle().focus();
	});
	*/

	$('#login_from_guest').submit(function(event){
		event.preventDefault();

		var data = {
			'email'			  : $('#login_email').val(),
			'password'  	  : $('#login_password').val(),
			'stay_logged_in'  : $('input[name=stay_logged_in]').val()
		};

		$.ajax({
			type      : 'POST',
			url       : '../chat/login_form_fields.php',
			data      : data,
			dataType  : 'json',
		})
		.done(function(data) {
			console.log(data);
			if(data.errors) {
				if(data.errors.email){
					//alert(data.errors.email);
					$('#login_email_error').text(data.errors.email);
					//$('#login_email').addClass('red_border');
				}
				if(data.errors.password) {
					//alert(data.errors.password);
					$('#login_password_error').text(data.errors.password);
					//$('#login_password').addClass('red_border');
				}	
			}
			else {
				window.location.assign('../' + data.url);
				//alert(data.url);
			}
		});

	});


});