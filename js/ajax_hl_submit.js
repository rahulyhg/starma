$(document).ready(function(){

//HOUSE LORD UI

$('.hl_nav_wrapper').mouseenter(function() {
	$(this).children('.hl_exp').show();
});
$('.hl_nav_wrapper').mouseleave(function() {
	$(this).children('.hl_exp').hide();
});



$('.hl_nav').click(function(event){
	$('#hl_blurb').fadeOut(300);
	$('#hl_iconL').fadeOut(300);
	$('#hl_iconR').fadeOut(300);
	$('#palenquin_stars').fadeOut(300, function(){
		$('#hl_intro').show().html('<div id="hl_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
	});
	
	$('.hl_nav').removeClass('hln_selected');
	$(this).addClass('hln_selected');

	var hl_data = {
		'rising_sign_id'   :   $('input[name=rising_sign_id]').val(),
		'house_id'         :   $(this).children('.pass_house_id').val(),	
		'chart_id'   	   :   $('input[name=chart_id_e]').val(),			
		'house_of_res'     :   $(this).children('input[name=house_of_res]').val()
	};
		
			
	$.ajax({
		type: 'POST',
		url: 'chat/houses_submit.php',
		data: hl_data,
		dataType: 'json',

	})
	.done(function(data){
		$('#hl_intro').hide();
		if (data.errors) {
			//$('#hl_iconL').hide();
			//$('#hl_iconR').hide();
			if (data.errors.rising_sign_id) {
				$('#hl_intro').show().text(data.errors.rising_sign_id);
			}
			if (data.errors.house_id) {
				$('#hl_intro').show().text(data.errors.house_id);
			}
			if (data.errors.house_of_res) {
				$('#hl_intro').show().text(data.errors.house_of_res);
			}
		}
		if (!data.errors) {
			$('#hl_blurb').show().text(data.blurb);
			$('#hl_iconL').show().html('<img src="/img/houseIcon_' + data.house_id + '.png" />').show();
			$('#hl_iconR').show().html('<img src="/img/houseIcon_' + data.house_of_res + '.png" />').show();
			$('#palenquin_stars').show();
			
		}
	});

});


//PREV BUTTON---------------------------------------

	$('#hl_prev').click(function(){
		$('#hl_blurb').fadeOut(300);
		$('#hl_iconL').fadeOut(300);
		$('#hl_iconR').fadeOut(300);
		$('#palenquin_stars').fadeOut(300, function(){
			$('#hl_intro').show().html('<div id="hl_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
		});

		$('div.hl_nav').removeClass('prev');
		if ($('div.hl_nav').hasClass('hln_selected')) {
			if($('.hln_selected').hasClass('hl_nav_icon_1')) {
				var prev = $('.hl_nav_icon_12');
			}
			if(!$('.hln_selected').hasClass('hl_nav_icon_1')) {
				//var index = $('.hln_selected').index();
				var prev = $('.hln_selected').prev();
				//alert(index);
			}
		}
		if (!$('div.hl_nav').hasClass('hln_selected')) {
			//alert('hasnot');
			var prev = $('div.hl_nav_icon_1');
			$('div.hl_nav_icon_1').addClass('hln_selected');
		}
		prev.addClass('prev');

		//$('#blurb').children().fadeOut(300);

			var hl_data = {
				'rising_sign_id'   :   $('input[name=rising_sign_id]').val(),
				'house_id'         :   prev.children('.pass_house_id').val(),
				'chart_id'   	   :   $('input[name=chart_id_e]').val(),				
				'house_of_res'     :   prev.children('input[name=house_of_res]').val()
				};
		
			
			$.ajax({
				type: 'POST',
				url: 'chat/houses_submit.php',
				data: hl_data,
				dataType: 'json',

			})
			.done(function(data) {
				$('#hl_intro').hide();
				if (data.errors) {
					//$('#hl_iconL').hide();
					//$('#hl_iconR').hide();
					if (data.errors.rising_sign_id) {
						$('#hl_intro').show().text(data.errors.rising_sign_id);
					}
					if (data.errors.house_id) {
						$('#hl_intro').show().text(data.errors.house_id);
					}
					if (data.errors.house_of_res) {
						$('#hl_intro').show().text(data.errors.house_of_res);
					}
				}
				if (!data.errors) {
					$('#hl_blurb').show().text(data.blurb);
					$('#hl_iconL').show().html('<img src="/img/houseIcon_' + data.house_id + '.png" />').show();
					$('#hl_iconR').show().html('<img src="/img/houseIcon_' + data.house_of_res + '.png" />').show();
					$('#palenquin_stars').show();			
				}
			
			$('div.hl_nav').removeClass('hln_selected');
			$('.prev').addClass('hln_selected');
			});
	});


//NEXT BUTTON---------------------------------------

	$('#hl_next').click(function(){
		$('#hl_blurb').fadeOut(300);
		$('#hl_iconL').fadeOut(300);;
		$('#hl_iconR').fadeOut(300);
		$('#palenquin_stars').fadeOut(300, function(){
			$('#hl_intro').show().html('<div id="hl_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
		});

		$('div.hl_nav').removeClass('next');
		if ($('div.hl_nav').hasClass('hln_selected')) {
			if($('.hln_selected').hasClass('hl_nav_icon_1')) {
				var next = $('.hl_nav_icon_2');
			}
			if(!$('.hln_selected').hasClass('hl_nav_icon_1')) {
				if ($('.hln_selected').hasClass('hl_nav_icon_12')) {
					var next = $('.hl_nav_icon_1');
				}
				if (!$('.hln_selected').hasClass('hl_nav_icon_12')) {
					var next = $('.hln_selected').next();
				}
			}
		}
		if (!$('div.hl_nav').hasClass('hln_selected')) {
			//alert('hasnot');
			var next = $('div.hl_nav_icon_1');
			$('div.hl_nav_icon_1').addClass('hln_selected');
		}
		next.addClass('next');

		//$('#blurb').children().fadeOut(300);

			var hl_data = {
				'rising_sign_id'   :   $('input[name=rising_sign_id]').val(),
				'house_id'         :   next.children('.pass_house_id').val(),
				'chart_id'   	   :   $('input[name=chart_id_e]').val(),				
				'house_of_res'     :   next.children('input[name=house_of_res]').val()
				};
		
			
			$.ajax({
				type: 'POST',
				url: 'chat/houses_submit.php',
				data: hl_data,
				dataType: 'json',

			})
			.done(function(data) {
				$('#hl_intro').hide();
				if (data.errors) {
					//$('#hl_iconL').hide();
					//$('#hl_iconR').hide();
					if (data.errors.rising_sign_id) {
						$('#hl_intro').show().text(data.errors.rising_sign_id);
					}
					if (data.errors.house_id) {
						$('#hl_intro').show().text(data.errors.house_id);
					}
					if (data.errors.house_of_res) {
						$('#hl_intro').show().text(data.errors.house_of_res);
					}
				}
				if (!data.errors) {
					$('#hl_blurb').show().text(data.blurb);
					$('#hl_iconL').show().html('<img src="/img/houseIcon_' + data.house_id + '.png" />').show();
					$('#hl_iconR').show().html('<img src="/img/houseIcon_' + data.house_of_res + '.png" />').show();
					$('#palenquin_stars').show();
			
				}
			
			$('div.hl_nav').removeClass('hln_selected');
			$('.next').addClass('hln_selected');
			});
	});

});