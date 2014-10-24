$(document).ready(function(){
		
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
				var old_picture = $('.fitter').children('img').attr('src');
				//alert(data.message);
				//alert(data.picture);
				$('.fitter').children('img').attr('src', '/img/user/' + data.picture);
				$(this).siblings('a').children('img').attr('src', 'img/user/' + data.old_picture);
				$(this).siblings('a').attr('href', 'img/user/compare/compare_' + data.old_picture);
				$(this).siblings('input[name=p_id]').val(data.main_id);
				//alert(old_picture);
			}
			//alert(data.message);
			//$('.fitter').children('img').attr('src', '/img/user/' + )
		});

	});


//DELETE PHOTO-------------------
	$('.delete_photo').click(function(event){
		event.preventDefault();
		var p_id = {'p_id'            :  $(this).siblings('input[name=p_id]').val()};

		$.ajax({
			context  : this,
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
				$(this).parent('td').removeClass('has_photo').addClass('later_on no_photo').html('<div class="div_no_photo later_on">Upload<br> a<br> Photo</div>');
			}
		});
	});




//ERROR HANDLING----------------
/*
	$('.pop_photo').show();
	if ($('#p_err_1').length) {
		$('.pop_photo').show();
		alert('error');
	}
	if ($('#p_err_2').length) {
		$('.pop_photo').show();
		alert('error');
	}
	if ($('#p_err_3').length()) {
		$('.pop_photo').show();
		alert('error');
	}
	if ($('#p_err_4').length) {
		$('.pop_photo').show();
		alert('error');
	}
	*/
	if ($('#p_err_id').val() != 0) {
		$('.pop_photo').show();
		alert('error');
	}

//UPLOAD PHOTO-----------------
/*
	$('#form_photo').submit(function(event){
		event.preventDefault();

	});
*/

});