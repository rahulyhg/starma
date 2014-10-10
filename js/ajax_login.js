$(document).ready(function(){
	/*
	$('#pass').on('focus', function(){
		$(this).toggle();
		$('#login_password').toggle().focus();
	});
	*/

	$('input[name=stay_logged_in]').click(function() {
		if ($('input[name=stay_logged_in]').is(':checked')) {
			$('input[name=stay_logged_in]').val('on');
		}
		else {
			$('input[name=stay_logged_in]').val('');
		}
	});
		

	$('#login_email').on('keyup', function(){
		$(this).css('border', '1px solid #1a1d2a');
	});

	$('#login_password').on('keyup', function(){
		$(this).css('border', '1px solid #1a1d2a');
	});

	$('#login_button_div').click(function(event){
		$('#login_from_landing').submit(function(event){
			event.preventDefault();

			var data = {
				'email'			  : $('#login_email').val(),
				'password'  	  : $('#login_password').val(),
				'stay_logged_in'  : $('input[name=stay_logged_in]').val()
			};

			$.ajax({
				type      : 'POST',
				url       : '/chat/login_form_fields.php',
				data      : data,
				dataType  : 'json',
			})
			.done(function(data) {
				console.log(data);
				if(data.errors) {
					if(data.errors.email){
						//alert(data.errors.email);
						//$('#login_email_error').text(data.errors.email);
						$('#login_email').css('border', '1px solid #C82923');
					}
					if(data.errors.password) {
						//alert(data.errors.password);
						//$('#login_password_error').text(data.errors.password);
						$('#login_password').css('border', '1px solid #C82923');
					}	
				}
				else {
					window.location.assign('/' + data.url);
					//alert(data.url);
				}
			});
		});

	});


	$('#login_from_guest').submit(function(event){
		event.preventDefault();

		var data = {
			'email'			  : $('#login_email').val(),
			'password'  	  : $('#login_password').val(),
			'stay_logged_in'  : $('input[name=stay_logged_in]').val()
		};

		$.ajax({
			type      : 'POST',
			url       : '/chat/login_form_fields.php',
			data      : data,
			dataType  : 'json',
		})
		.done(function(data) {
			console.log(data);
			if(data.errors) {
				if(data.errors.email){
					//alert(data.errors.email);
					//$('#login_email_error').text(data.errors.email);
					$('#login_email').css('border', '1px solid #C82923');
				}
				if(data.errors.password) {
					//alert(data.errors.password);
					//$('#login_password_error').text(data.errors.password);
					$('#login_password').css('border', '1px solid #C82923');
				}	
			}
			else {
				window.location.assign('/' + data.url);
				//alert(data.url);
			}
		});

	});


});