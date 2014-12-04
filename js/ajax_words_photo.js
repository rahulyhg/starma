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

//ERRORS EXP--------------

	$('#w_1_error').mouseenter(function(){
		$('#w_1_err_exp').show();
	});
	$('#w_1_error').mouseleave(function(){
		$('#w_1_err_exp').hide();
	});
	$('#w_1_error').click(function(){
		$('#w_1_err_exp').toggle();
	});
	$('#w_2_error').mouseenter(function(){
		$('#w_2_err_exp').show();
	});
	$('#w_2_error').mouseleave(function(){
		$('#w_2_err_exp').hide();
	});
	$('#w_2_error').click(function(){
		$('#w_2_err_exp').toggle();
	});
	$('#w_3_error').mouseenter(function(){
		$('#w_3_err_exp').show();
	});
	$('#w_3_error').mouseleave(function(){
		$('#w_3_err_exp').hide();
	});
	$('#w_3_error').click(function(){
		$('#w_3_err_exp').toggle();
	});
	$('#p_error').mouseenter(function(){
		$('#p_err_exp').show();
	});
	$('#p_error').mouseleave(function(){
		$('#p_err_exp').hide();
	});
	$('#p_error').click(function(){
		$('#p_err_exp').toggle();
	});



//WORDS POST

	$('#word_1').on('blur', function() {
		$('#desc1').val($('#word_1').val());

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
					$('#word_1').css('border', '2px solid black').removeClass('error');
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
		$('#desc2').val($('#word_2').val());

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
					$('#word_2').css('border', '2px solid black').removeClass('error');
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
		$('#desc3').val($('#word_3').val());
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
					$('#word_3').css('border', '2px solid black').removeClass('error');
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



//BROWSE------------------

	$('#image').click(function(event) {
		if ($('#word_1').val() == '' || $('#word_2').val() == '' || $('#word_3').val() == '') {
			event.preventDefault();
			if ($('#word_1').val() == '') {
				$('#word_1').css('border', '2px solid #C82923').addClass('error');
			}
			if ($('#word_2').val() == '') {
				$('#word_2').css('border', '2px solid #C82923').addClass('error');
			}
			if ($('#word_3').val() == '') {
				$('#word_3').css('border', '2px solid #C82923').addClass('error');
			}
			if ($('#word_1').hasClass('error') || $('#word_2').hasClass('error') || $('#word_3').hasClass('error')) {
					$('#upload_photo').prop('disabled', true);
			}
		}
		if (!$('#word_1').hasClass('error') && !$('#word_2').hasClass('error') && !$('#word_3').hasClass('error')) {
			$('#upload_photo').show().prop('disabled', false);
		}
	});


//UPLOAD PHOTO--------------
	/*
	$('#form_photo').submit(function(event){
		//event.preventDefault();
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
		else {
			$('#desc1').val() = $('#word_1').val();
			$('#desc2').val() = $('#word_2').val();
			$('#desc3').val() = $('#word_3').val();
		}
		
		else {

			var words = {
				'word_1'  :  $('#word_1').val(),
				'word_2'  :  $('#word_2').val(),
				'word_3'  :  $('#word_3').val(),
			};

			$.post('/chat/process_photo_sign_up.php', words, function(data){
				if(data.errors) {	
					
				}
				if(data.success) {
					
					//window.location.assign('/' + data.url);			
				}
			}, 'json');
		}
		
	});
	*/


//SUBMIT---------------
//$('#next').click(function(event) {
	$('#words_photo_form').submit(function(event) {
		event.preventDefault();
		/*
		if ($('#word_1').val() == '' || $('#word_2').val() == '' || $('#word_3').val() == '') {
			if ($('#word_1').val() == '') {
				$('#word_1').css('border', '2px solid #C82923').addClass('error');
			}
			if ($('#word_2').val() == '') {
				$('#word_2').css('border', '2px solid #C82923').addClass('error');
			}
			if ($('#word_3').val() == '') {
				$('#word_3').css('border', '2px solid #C82923').addClass('error');
			}
		}
		
		*/
		$('#step').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
		
		//else {
			var words = {
			'word_1'       :  $('#word_1').val(),
			'word_2'       :  $('#word_2').val(),
			'word_3'       :  $('#word_3').val(),
			'words'        :  $('#words').val(),
			'crop_error'   :  $('#crop_error').val(),
			};

		$.ajax({
			type     : 'POST',
			url      : '/chat/ajax_words_photo.php', 
			data     : words, 
			dataType : 'json',
		})
		.done(function(data){
				if(data.errors) {	
					$('#step').html('').text('2 / 3');
					if (data.errors.word1) {
						$('#word_1').css('border', '2px solid #C82923').addClass('error');
						$('#w_1_error').show().text('?');
						$('#w_1_err_exp').text(data.errors.word1);
					}
					if (data.errors.word2) {
						$('#word_2').css('border', '2px solid #C82923').addClass('error');
						$('#w_2_error').show().text('?');
						$('#w_2_err_exp').text(data.errors.word2);
					}
					if (data.errors.word3) {
						$('#word_3').css('border', '2px solid #C82923').addClass('error');
						$('#w_3_error').show().text('?');
						$('#w_3_err_exp').text(data.errors.word3);
					}
					if (data.errors.photo) {
						$('#p_error').show().text('?');
						$('#p_err_exp').text(data.errors.photo);
					}
				}
				if(data.success) {
					window.location.assign('/' + data.url);			
				}
			});
		//}

	//});
});
	/*
	$('#continue').click(function(event){
		window.location.replace('/sign_up.php?3');
	});
	*/
	/*
					$('#step').html('').text('2 / 3');
					$('#word_1').css('border', '2px solid #d1d1d1').removeClass('error');
					$('#w_1_error').hide().text('');
					$('#w_1_err_exp').text('');
					$('#word_2').css('border', '2px solid #d1d1d1').removeClass('error');
					$('#w_2_error').hide().text('');
					$('#w_2_err_exp').text('');
					$('#word_3').css('border', '2px solid #d1d1d1').removeClass('error');
					$('#w_3_error').hide().text('');
					$('#w_3_err_exp').text('');	
					*/
	


});