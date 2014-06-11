$(document).ready(function(){

	$('input[name=change_pass]').prop('disabled', true);

	$('input[name=password2]').on('keyup', function() {
			var new_pass = $('input[name=password]').val();
			var new_pass2 = $('input[name=password2]').val();
			if(new_pass != "") {
				if(new_pass == new_pass2) {
					$('.pass_correct').show().fadeOut(1200);
					$('input[name=change_pass]').prop('disabled', false);
					//alert('correct!');
				}
				else {
					$('input[name=change_pass]').prop('disabled', true);
				}
			}
		});

	
	//if ($('input[name=change_pass]').prop('disabled', false)) {
		
		$('#change_pass').click(function(){
			$('#ajax_loader').html('<img src="/js/ajax_loader.gif" />');
			var data_pass = {
				'oldpassword'  : $('input[name=oldpassword]').val(),
				'password'     : $('input[name=password]').val(),
				'password2'    : $('input[name=password2]').val()
				};

			$.ajax({
				type: 'POST',
				url: 'chat/ajax_change_password.php',
				data: data_pass,
				dataType: 'json',

				})

				.done(function(data) {
					//alert(data);
					if (data.success) {
						$('#ajax_loader').html('');
						$('#pass_validation').show().html('Your password has been updated!').css('color', 'green');
						//alert(data.pass);
					}
					if (data.errors) {
						$('#ajax_loader').html('');
						$('#pass_validation').css('color', 'red');
						if(data.errors.pass_length){	
							$('#pass_validation').show().text('*' + data.errors.pass_length);
						}
						if(data.errors.oldpass) {
							$('#pass_validation').show().text('*' + data.errors.oldpass);
						}
						if(data.errors.mismatch) {
							$('#pass_validation').show().text('*' + data.errors.mismatch);
						}
						if(data.errors.characters) {
							$('#pass_validation').show().text('*' + data.errors.characters);
						}
					}
					$('input[name=oldpassword]').val('');
					$('input[name=password]').val('');
					$('input[name=password2]').val('');
				});

				//event.preventDefault();
		});
	//}
	
	


});