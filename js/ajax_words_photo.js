$(document).ready(function() {

//timer vars

	//var timer_word_1;
	//var timer_word_2;
	//var timer_word_3;
$('#continue').prop('disabled', true);

if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
	$('#upload_photo').prop('disabled', true);
}

if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
	$('#upload_photo').prop('disabled', false);
}

//showing errors exp 

	$('#w_1_error').mouseenter(function(){
		$('#w_1_err_exp').show();
	});
	$('#w_1_error').mouseleave(function(){
		$('#w_1_err_exp').hide();
	});
	$('#w_2_error').mouseenter(function(){
		$('#w_2_err_exp').show();
	});
	$('#w_2_error').mouseleave(function(){
		$('#w_2_err_exp').hide();
	});
	$('#w_3_error').mouseenter(function(){
		$('#w_3_err_exp').show();
	});
	$('#w_3_error').mouseleave(function(){
		$('#w_3_err_exp').hide();
	});




//WORDS POST

	$('#word_1').on('blur', function() {

		//clearInterval(timer_word_1);
		//timer_word_1 = setTimeout(function() {
			var word1_q = { 'word1_q' : $('#word_1').val()};

			$.post('/chat/ajax_words_photo.php', word1_q, function(data){
				//if (data.errors) {
				//	$('#word_1').css('border', '1px solid #C82923');
				//	$('#w_1_error').show().text('?');
				//	$('#w_1_err_exp').text(data.errors);
				//}
				if(data.fixed1) {
					$('#word_1').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_1_error').hide().text('');
					$('#w_1_err_exp').text('');
					if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
					}

					if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', false);
					}
				}
				else {
					if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
					}

					if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', false);
					}
				}
			}, 'json');

		//}, 700);
	});

	$('#word_2').on('blur', function() {

		//clearInterval(timer_word_2);
		//timer_word_2 = setTimeout(function() {
			var word2_q = { 'word2_q' : $('#word_2').val()};

			$.post('/chat/ajax_words_photo.php', word2_q, function(data){
				//if (data.errors) {
				//	$('#word_2').css('border', '1px solid #C82923');
				//	$('#w_2_error').show().text('?');
				//	$('#w_2_err_exp').text(data.errors);
				//}
				if(data.fixed2) {
					$('#word_2').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_2_error').hide().text('');
					$('#w_2_err_exp').text('');
					if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
					}

					if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', false);
					}
				}
				else {
					if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
					}

					if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', false);
					}
				}
			}, 'json');

		//}, 1000);
	});

	$('#word_3').on('blur', function() {

		//clearInterval(timer_word_3);
		//timer_word_3 = setTimeout(function() {
			var word3_q = { 'word3_q' : $('#word_3').val()};

			$.post('/chat/ajax_words_photo.php', word3_q, function(data){
				//if (data.errors) {
				//	$('#word_3').css('border', '1px solid #C82923');
				//	$('#w_3_error').show().text('?');
				//	$('#w_3_err_exp').text(data.errors);
				//}
				if(data.fixed3) {
					$('#word_3').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_3_error').hide().text('');
					$('#w_3_err_exp').text('');
					if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
					}

					if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', false);
					}
				}
				else {
					if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
					}

					if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', false);
					}
				}
			}, 'json');

		//}, 1000);
	});


	$('#image').click(function(event) {
		if ($('#word_1').val() == '' || $('#word_2').val() == '' || $('#word_3').val() == '') {
			event.preventDefault();
			if ($('#word_1').val() == '') {
				$('#word_1').css('border', '1px solid #C82923').addClass('error');
			}
			if ($('#word_2').val() == '') {
				$('#word_2').css('border', '1px solid #C82923').addClass('error');
			}
			if ($('#word_3').val() == '') {
				$('#word_3').css('border', '1px solid #C82923').addClass('error');
			}
			if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
					$('#upload_photo').prop('disabled', true);
				}
			if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
				$('#upload_photo').prop('disabled', false);
			}
		}

		var words = {
			'word_1'  :  $('#word_1').val(),
			'word_2'  :  $('#word_2').val(),
			'word_3'  :  $('#word_3').val(),
		};

		$.post('/chat/ajax_words_photo.php', words, function(data){
				if(data.errors) {	
					if (data.errors.word1) {
						$('#word_1').css('border', '1px solid #C82923').addClass('error');
						$('#w_1_error').show().text('?');
						$('#w_1_err_exp').text(data.errors.word1);
					}
					if (data.errors.word2) {
						$('#word_2').css('border', '1px solid #C82923').addClass('error');
						$('#w_2_error').show().text('?');
						$('#w_2_err_exp').text(data.errors.word2);
					}
					if (data.errors.word3) {
						$('#word_3').css('border', '1px solid #C82923').addClass('error');
						$('#w_3_error').show().text('?');
						$('#w_3_err_exp').text(data.errors.word3);
					}
				}
				if(data.success) {
					$('#word_1').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_1_error').hide().text('');
					$('#w_1_err_exp').text('');
					$('#word_2').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_2_error').hide().text('');
					$('#w_2_err_exp').text('');
					$('#word_3').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_3_error').hide().text('');
					$('#w_3_err_exp').text('');				
				}
				if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
						$('#upload_photo').prop('disabled', true);
				}

				if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
					$('#upload_photo').prop('disabled', false);
				}
			}, 'json');
	});


	//SUBMIT

	$('#words_photo_form').submit(function(event) {
		event.preventDefault();
		if ($('#word_1').val() == '' || $('#word_2').val() == '' || $('#word_3').val() == '') {
			if ($('#word_1').val() == '') {
				$('#word_1').css('border', '1px solid #C82923').addClass('error');
			}
			if ($('#word_2').val() == '') {
				$('#word_2').css('border', '1px solid #C82923').addClass('error');
			}
			if ($('#word_3').val() == '') {
				$('#word_3').css('border', '1px solid #C82923').addClass('error');
			}
		}
		
			var words = {
			'word_1'  :  $('#word_1').val(),
			'word_2'  :  $('#word_2').val(),
			'word_3'  :  $('#word_3').val(),
			};

		$.post('/chat/ajax_words_photo.php', words, function(data){
				if(data.errors) {	
					if (data.errors.word1) {
						$('#word_1').css('border', '1px solid #C82923').addClass('error');
						$('#w_1_error').show().text('?');
						$('#w_1_err_exp').text(data.errors.word1);
					}
					if (data.errors.word2) {
						$('#word_2').css('border', '1px solid #C82923').addClass('error');
						$('#w_2_error').show().text('?');
						$('#w_2_err_exp').text(data.errors.word2);
					}
					if (data.errors.word3) {
						$('#word_3').css('border', '1px solid #C82923').addClass('error');
						$('#w_3_error').show().text('?');
						$('#w_3_err_exp').text(data.errors.word3);
					}
				}
				if(data.success) {
					$('#word_1').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_1_error').hide().text('');
					$('#w_1_err_exp').text('');
					$('#word_2').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_2_error').hide().text('');
					$('#w_2_err_exp').text('');
					$('#word_3').css('border', '1px solid #d1d1d1').removeClass('error');
					$('#w_3_error').hide().text('');
					$('#w_3_err_exp').text('');				
				}
			}, 'json');

		});
	
	$('#continue').click(function(event){
		window.location.replace('/sign_up.php?3');
	});

});