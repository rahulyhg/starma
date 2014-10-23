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
		$(this).children('.make_profile_pic, .delete_photo').animate({opacity: 'toggle'}, 500);
	});

	$('.make_profile_pic').click(function(event) {
		event.preventDefault();

		var p_id = {'p_id'            :  $(this).siblings('input[name=p_id]').val()};
		//alert(p_id);

		$.ajax({
			context  : this,
			type     : 'POST',
			url      : '/chat/change_profile_pic.php',
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
				$(this).siblings('a').children('img').attr('src', 'img/user/compare/compare_' + data.old_picture);
				$(this).siblings('a').attr('href', 'img/user/compare/compare_' + data.old_picture);
				$(this).siblings('input[name=p_id]').val(data.main_id);
				//alert(old_picture);
			}
			//alert(data.message);
			//$('.fitter').children('img').attr('src', '/img/user/' + )
		});

	});
});