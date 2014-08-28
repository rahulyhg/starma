$(document).ready(function() {

	$('#word_1').on('keyup', function() {

	});

	$('#submit').click(function(event) {

		if ($('#word_1').val() == '' || $('#word_2').val() == '' || $('#word_3').val() == '') {
			event.preventDefault();
			if ($('#word_1').val() == '') {
				$('#word_1').css('border', '1px solid #C82923');
			}
			if ($('#word_2').val() == '') {
				$('#word_2').css('border', '1px solid #C82923');
			}
			if ($('#word_3').val() == '') {
				$('#word_3').css('border', '1px solid #C82923');
			}
		}
		
		var words = {
			'word_1'  :  $('#word_1').val(),
			'word_2'  :  $('#word_2').val(),
			'word_3'  :  $('#word_3').val(),
		};

		$.post('/chat/ajax_words_photo.php', words, function(data){
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
					$('#reg_username_error').show().removeClass('register_error').addClass('check').text(data.message);
					$('#register_username').css('border', '1px solid #d1d1d1');
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

		$('#words_photo_form').submit(function(event) {

		});

	});


});