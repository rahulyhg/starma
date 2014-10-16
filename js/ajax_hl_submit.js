$(document).ready(function(){


//SUBMIT FROM LI------------------------------

	$('.hl_li').click(function(){
		if ($(this).children().children('.pass_house_id').val() !== 1) {
			$('#hl_prev').show();
			$('#hl_next').show();
		}
		if ($(this).children().children('.pass_house_id').val() == 1) {
			$('#hl_prev').hide();
			$('#hl_next').show();
		}
		if ($(this).children().children('.pass_house_id').val() == 12) {
			$('#hl_next').hide();
		}

		$('#blurb').children().fadeOut(300);

		
			var hl_data = {
				'rising_sign_id'   :   $('input[name=rising_sign_id]').val(),
				'house_id'         :   $(this).children().children('.pass_house_id').val(),	
				'chart_id'   	   :   $('input[name=chart_id_e]').val(),			
				'house_of_res'     :   $(this).children().children('input[name=house_of_res]').val()
				};
		
			
			$.ajax({
				type: 'POST',
				url: 'chat/houses_submit.php',
				data: hl_data,
				dataType: 'json',

			})

			.done(function(data) {
				//alert('poi_id: ' + data.poi_id + ' - chart_id: ' + data.chart_id 
				//	+ ' - sign_id: ' + data.sign_id + ' - poi_info: ' + data.poi_info + ' - blurb: ' + data.blurb);
				if (data.errors) {
					if(data.errors.rising_sign_id) {
						$('#rising_sign_id_err').text(data.blurb).fadeIn(800);
					}
					if(data.errors.house_id) {
						$('#house_id_err').text(data.house_id).fadeIn(800);
					}
					if(data.errors.house_of_res) {
						$('#house_of_res_err').text(data.house_of_res).fadeIn(300);
					}
				}
				if(data.blurb == null) {
					$('#blurb').html('<div id="palenquin_wrapper"><div id="house_pic_test_left" class="house_pic_' + data.house_id + '"></div><div id="palenquin_stars"></div><div id="house_pic_test_right" class="house_pic_' + data.house_of_res + '"></div></div><div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
				}
				if(data.blurb !== null) {
					$('#blurb').html('<div id="palenquin_wrapper"><div id="house_pic_test_left" class="house_pic_' + data.house_id + '"></div><div id="palenquin_stars"></div><div id="house_pic_test_right" class="house_pic_' + data.house_of_res + '"></div></div><div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
				}
			});

			$('li.hl_li').removeClass('selected');
			$(this).addClass('selected');
			$('.arrow').removeClass('arrow_left_on arrow_right_on');
			if($(this).children().children('.icon').hasClass('left')) {
				$(this).children().children('.arrow').addClass('arrow_left_on');
			}
			else {
				$(this).children().children('.arrow').addClass('arrow_right_on');
			}

	});

//PREV BUTTON---------------------------------------

	$('#hl_prev').click(function(){
		$('div.hl_tabs>ul>li').removeClass('prev');
		if ($('div.hl_tabs>ul>li.selected').children().children('.pass_house_id').val() !== 7) {
			var prev = $('div.hl_tabs>ul>li.selected').prev('li');
			//alert(prev.children().children('.pass_poi_id').val());
			//alert('hello');
		}
		if ($('div.hl_tabs>ul>li.selected').children().children('.pass_house_id').val() == 7) {
			var prev = $('div.left_side>ul>li:eq(5)');
			//alert(prev.children().children('.pass_poi_id').val());
		}
		$(prev).addClass('prev');
		//alert($('li.selected').prev('li').children().children('.pass_poi_id').val());
		
		if (prev.children().children('.pass_house_id').val() !== 1) {
			$('#hl_prev').show();
			$('#hl_next').show();
		}
		if (prev.children().children('.pass_house_id').val() == 1) {
			$('#hl_prev').hide();
			$('#hl_next').show();
		}
		if (prev.children().children('.pass_house_id').val() == 12) {
			$('#hl_next').hide();
		}

		//$('#planet_info').html().fadeOut('fast');
		$('#blurb').children().fadeOut(300);
		

			var hl_data = {
				'rising_sign_id'   :   $('input[name=rising_sign_id]').val(),
				'house_id'         :   prev.children().children('.pass_house_id').val(),
				'chart_id'   	   :   $('input[name=chart_id_e]').val(),				
				'house_of_res'     :   prev.children().children('input[name=house_of_res]').val()
				};
		
			
			$.ajax({
				type: 'POST',
				url: 'chat/houses_submit.php',
				data: hl_data,
				dataType: 'json',

			})
			.done(function(data) {
				//alert('poi_id: ' + data.poi_id + ' - chart_id: ' + data.chart_id 
				//	+ ' - sign_id: ' + data.sign_id + ' - poi_info: ' + data.poi_info + ' - blurb: ' + data.blurb);
				if (data.errors) {
					if(data.errors.rising_sign_id) {
						$('#rising_sign_id_err').text(data.blurb).fadeIn(800);
					}
					if(data.errors.house_id) {
						$('#house_id_err').text(data.house_id).fadeIn(800);
					}
					if(data.errors.house_of_res) {
						$('#house_of_res_err').text(data.house_of_res).fadeIn(300);
					}
				}
				if(data.blurb == null) {
					//$('#blurb').html('<div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
					$('#blurb').html('<div id="palenquin_wrapper"><div id="house_pic_test_left" class="house_pic_' + data.house_id + '"></div><div id="palenquin_stars"></div><div id="house_pic_test_right" class="house_pic_' + data.house_of_res + '"></div></div><div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
				}
				if(data.blurb !== null) {
					$('#blurb').html('<div id="palenquin_wrapper"><div id="house_pic_test_left" class="house_pic_' + data.house_id + '"></div><div id="palenquin_stars"></div><div id="house_pic_test_right" class="house_pic_' + data.house_of_res + '"></div></div><div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
				}
			});

			$('li.hl_li').removeClass('selected');
			$('.prev').addClass('selected');
			$('.arrow').removeClass('arrow_left_on arrow_right_on');
			if($('.prev').children().children('.icon').hasClass('left')) {
				$('.prev').children().children('.arrow').addClass('arrow_left_on');
			}
			else {
				$('.prev').children().children('.arrow').addClass('arrow_right_on');
			}
		
	});



//NEXT BUTTON---------------------------------

	$('#hl_next').click(function(){
		//alert($('li.selected').next('li').children().children('.pass_poi_id').val());
		$('div.hl_tabs>ul>li').removeClass('next');
		if ($('div.hl_li>ul>li.selected').children().children('.pass_house_id').val() !== 6) {
			var next = $('div.hl_tabs>ul>li.selected').next('li');
			//alert(prev.children().children('.pass_poi_id').val());
			//alert('hello');
		}
		if ($('div.hl_tabs>ul>li.selected').children().children('.pass_house_id').val() == 6) {
			var next = $('div.right_side>ul>li:eq(0)');
			//alert(prev.children().children('.pass_poi_id').val());
		}
		$(next).addClass('next');
		//alert($('li.selected').prev('li').children().children('.pass_poi_id').val());
		
		if (next.children().children('.pass_house_id').val() !== 1) {
			$('#hl_prev').show();
			$('#hl_next').show();
		}
		if (next.children().children('.pass_house_id').val() == 1) {
			$('#hl_prev').hide();
			$('#hl_next').show();
		}
		if (next.children().children('.pass_house_id').val() == 12) {
			$('#hl_next').hide();
		}

		//$('#planet_info').html().fadeOut('fast');
		$('#blurb').children().fadeOut(300);
		

		var hl_data = {
				'rising_sign_id'   :   $('input[name=rising_sign_id]').val(),
				'house_id'         :   next.children().children('.pass_house_id').val(),
				'chart_id'		   :   $('input[name=chart_id_e]').val(),				
				'house_of_res'     :   next.children().children('input[name=house_of_res]').val()
				};
		
			
			$.ajax({
				type: 'POST',
				url: 'chat/houses_submit.php',
				data: hl_data,
				dataType: 'json',

			})
			.done(function(data) {
				//alert('poi_id: ' + data.poi_id + ' - chart_id: ' + data.chart_id 
				//	+ ' - sign_id: ' + data.sign_id + ' - poi_info: ' + data.poi_info + ' - blurb: ' + data.blurb);
				if (data.errors) {
					if(data.errors.rising_sign_id) {
						$('#rising_sign_id_err').text(data.blurb).fadeIn(800);
					}
					if(data.errors.house_id) {
						$('#house_id_err').text(data.house_id).fadeIn(800);
					}
					if(data.errors.house_of_res) {
						$('#house_of_res_err').text(data.house_of_res).fadeIn(300);
					}
				}
				if(data.blurb == null) {
					//$('#blurb').html('<div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
					$('#blurb').html('<div id="palenquin_wrapper"><div id="house_pic_test_left" class="house_pic_' + data.house_id + '"></div><div id="palenquin_stars"></div><div id="house_pic_test_right" class="house_pic_' + data.house_of_res + '"></div></div><div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
				}
				if(data.blurb !== null) {
					$('#blurb').html('<div id="palenquin_wrapper"><div id="house_pic_test_left" class="house_pic_' + data.house_id + '"></div><div id="palenquin_stars"></div><div id="house_pic_test_right" class="house_pic_' + data.house_of_res + '"></div></div><div id="hl_blurb">' + data.blurb + '</div>').fadeIn(800);
				}
			});

			$('li.hl_li').removeClass('selected');
			$('.next').addClass('selected');
			$('.arrow').removeClass('arrow_left_on arrow_right_on');
			if($('.next').children().children('.icon').hasClass('left')) {
				$('.next').children().children('.arrow').addClass('arrow_left_on');
			}
			else {
				$('.next').children().children('.arrow').addClass('arrow_right_on');
			}
	});


});