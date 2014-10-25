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

	$('.has_photo1').on('mouseenter tap', function(event) {
		$(this).children('.make_profile_pic, .delete_photo1').animate({opacity: 'toggle'}, 500);
	});

	$('.has_photo1').on('mouseleave tap', function(event) {
		$(this).children('.make_profile_pic, .delete_photo1').animate({opacity: 'toggle'}, 100);
	});

	$('.has_photo2').on('mouseenter tap', function(event) {
		$(this).children('.make_profile_pic, .delete_photo2').animate({opacity: 'toggle'}, 500);
	});

	$('.has_photo2').on('mouseleave tap', function(event) {
		$(this).children('.make_profile_pic, .delete_photo2').animate({opacity: 'toggle'}, 100);
	});


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
				//SWAPS THE IMAGES DYNAMICALLY CLIENT SIDE AND UPON REFRESH THINGS WILL BE CHANGED IN THE CODE
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
		
		$('#cancel_delete_photo').prop('disabled', true);
		$('#confirm_delete_photo').prop('disabled', true);
		
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
					$('#cancel_delete_photo').prop('disabled', false);
					$('#confirm_delete_photo').prop('disabled', false);
				}						
				if (data.errors.valid) {
					alert(data.errors.valid);
					$('#cancel_delete_photo').prop('disabled', false);
					$('#confirm_delete_photo').prop('disabled', false);
				}
			}
			if (data.failed) {
				alert(data.failed);
				$('#cancel_delete_photo').prop('disabled', false);
				$('#confirm_delete_photo').prop('disabled', false);
			}
			if(data.url) {
				window.location.assign('/' + data.url);
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