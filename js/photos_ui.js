$(document).ready(function(){

//function select_input(i) {
//  return $('input[value="' + i + '"]').html();
//}
		
	$('#my_photos').magnificPopup({
		delegate : 'a',
		type     : 'image',
		gallery  : {
			enabled: true,
			navigateByImgClick: true,
			preload: [1,2] // Will preload 0 - before current, and 1 after the current image
		}
	});

	$('.has_photo').on('mouseenter tap', function(event) {
		$(this).children('.make_profile_pic, .delete_photo').animate({opacity: 'toggle'}, 500);
	});

	$('.has_photo').on('mouseleave tap', function(event) {
		$(this).children('.make_profile_pic, .delete_photo').animate({opacity: 'toggle'}, 100);
	});

	/*
	$('.no_photo').on('mouseenter', function(event) {
		$(this).children('.div_no_photo').css({'box-shadow' : '0 0 4px 0 inset black'});
	});

	$('.no_photo').on('mouseleave', function(event) {
		$(this).children('.div_no_photo').css('box-shadow', 'none');
	});
	*/

//MAKE PROFILE PIC------------------------

	$('.make_profile_pic').click(function(event) {
		event.preventDefault();

		var p_id = {'p_id'            :  $(this).siblings('input[name=p_id]').val()};
		//alert(p_id);

		$.ajax({
			context  : this,
			type     : 'POST',
			url      : '/chat/ajax_change_profile_pic.php',
			data     : p_id,
			dataType : 'json'
		})
		.done(function(data){
			if (data.errors) {
				if (data.errors.update) {
					alert(data.errors.update);
				}
				if (data.errors.picture) {
					alert(data.errors.picture);
				}
				if (data.errors.not_mine) {
					alert(data.errors.not_mine);
				}
			}
			if (data.success) {
				//var old_picture = $('.fitter').children('img').attr('src');
				//alert(data.message);
				//alert(data.picture);
				$('.fitter').children('img').attr('src', '/img/user/' + data.picture);
				$(this).siblings('a').children('img').attr('src', 'img/user/compare/compare_' + data.old_picture);
				$(this).siblings('a').attr('href', 'img/user/' + data.old_picture);
				$(this).siblings('input[name=p_id]').val(data.main_id);
				//alert(old_picture);
			}
			//alert(data.message);
			//$('.fitter').children('img').attr('src', '/img/user/' + )
		});

	});


//DELETE PHOTO-------------------
	
	$('.delete_photo').click(function(){
		var d_p_id = $(this).siblings('input[name=p_id]').val();
		$('.d_photo_pop').show();
		$('#d_p_id').val(d_p_id);
	});

	$('#cancel_delete_photo').click(function(){
		$('.d_photo_pop').hide();
		$('#d_p_id').val('');
	});

	$('#confirm_delete_photo').click(function(event){
		event.preventDefault();
		//var p_id = {'p_id'            :  $(this).siblings('input[name=p_id]').val()};
		var p_id = {'p_id'            :  $('#d_p_id').val()};

		$.ajax({
			//context  : this,
			type     : 'POST',
			url      : '/chat/ajax_delete_photo.php',
			data     : p_id,
			dataType : 'json'
		})
		.done(function(data){
			if (data.errors) { 
				if (data.errors.not_mine) {
					alert(data.errors.not_mine);
				}						
				if (data.errors.valid) {
					alert(data.errors.valid);
				}
			}
			if (data.failed) {
				alert(data.failed);
			}
			if(data.success) {
				var old_input_val = $('#d_p_id').val();
				$('#d_p_id').val('');
				//alert('<div>' + old_input + '</div>');
				//$('input[value="' + old_input_val +'"]').val(data.d_p_id);
				$('input[value="' + old_input_val +'"]').parent('td')removeClass('has_photo').addClass('later_on no_photo').html('<div class="div_no_photo later_on">Upload<br> a<br> Photo</div>');
				//$('.d_photo_pop').slideFadeToggle(function(){
				//	$('#d_p_id').val('');
				//});
				//$(this).parent('td').removeClass('has_photo').addClass('later_on no_photo').html('<div class="div_no_photo later_on">Upload<br> a<br> Photo</div>');
			}
		});
	});



//ERROR HANDLING----------------

	if ($('#p_err_id').length) {
		if ($('#p_err_id').val() != 0) {
			$('.pop_photo').show();
			//alert('error');
		}
	}

	if ($('.crop_pop').length) {
		$('.crop_pop').show();
	}



});