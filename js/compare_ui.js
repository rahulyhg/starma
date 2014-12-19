$(document).ready(function(){

//FOR VIEW TUTORIAL RELOAD ON RELOAD
	if ($('#minor_select').hasClass('selected')) {
		$('.selector').removeClass('selected');
		$('#minor_select').addClass('selected');
		$('.exp_less').text('Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs...');
		$('.exp_more').text('Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs - we call these the “Major Connections.”  You’re likely to see both positive and negative dynamics, so keep in mind that a relationship can work with even one good dynamic!  It’s also normal to encounter contradictory information, so be sure to remember the Cake Analogy!  Enjoy!');
		$('#explain_more').show();
		$('#minor').show();
		$('#major').hide();
		$('#ruler').hide();
		$('#bonus').hide();
	}

	//Explanation
		$('#explain_more').click(function(){
			var text = $(this).text();
			if(text == 'MORE') {
				$(this).text('LESS');
				$('#explanation').removeClass('explanation_less');
				$('#explanation').addClass('explanation_more');
				$('.exp_less').hide();
				$('.exp_more').show();
			}
			else {
				$(this).text('MORE');
				$('#explanation').removeClass('explanation_more');
				$('#explanation').addClass('explanation_less');
				$('.exp_less').show();
				$('.exp_more').hide();
			}
		});

	

	//Selector
		$('#major_select').click(function(){
			$('.selector').removeClass('selected');
			$('#major_select').addClass('selected');
			$('.exp_less').text('Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs...');
			$('.exp_more').text('Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs - we call these the “Major Connections.”  You’re likely to see both positive and negative dynamics, so keep in mind that a relationship can work with even one good dynamic!  It’s also normal to encounter contradictory information, so be sure to remember the Cake Analogy!  Enjoy!');
			$('#explain_more').show();
			$('#major').show();
			$('#minor').hide();
			$('#ruler').hide();
			$('#bonus').hide();
			mixpanel.track('Major Connections Selected');
		});
		$('#minor_select').click(function(){
			$('.selector').removeClass('selected');
			$('#minor_select').addClass('selected');
			$('.exp_less').text('Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs...');
			$('.exp_more').text('Many factors go into astrological compatibility, but a good place to start is with the dynamics between your Rising, Sun, Moon and Venus Signs - we call these the “Major Connections.”  You’re likely to see both positive and negative dynamics, so keep in mind that a relationship can work with even one good dynamic!  It’s also normal to encounter contradictory information, so be sure to remember the Cake Analogy!  Enjoy!');
			$('#explain_more').show();
			$('#minor').show();
			$('#major').hide();
			$('#ruler').hide();
			$('#bonus').hide();
			mixpanel.track('Minor Connections Selected');
		});
		$('#ruler_select').click(function(){
			$('.selector').removeClass('selected');
			$('#ruler_select').addClass('selected');
			$('.exp_less').text('This area is coming soon!');
			$('.exp_more').text('This area is coming soon!');
			$('#explain_more').hide();
			$('#ruler').show();
			$('#major').hide();
			$('#minor').hide();
			$('#bonus').hide();
			mixpanel.track('Ruling Planet Connection Selected');
		});
		$('#bonus_select').click(function(){
			$('.selector').removeClass('selected');
			$('#bonus_select').addClass('selected');
			$('.exp_less').text('This area is coming soon!');
			$('.exp_more').text('This area is coming soon!');
			$('#explain_more').hide();
			$('#bonus').show();
			$('#major').hide();
			$('#minor').hide();
			$('#ruler').hide();
			mixpanel.track('Jupiter Connection Selected');
		});

		
	//Major

		$('.right, .left, .dynamic_icon').click(function(){
			mixpanel.track('Minor Connection Dynamic Text Viewed');
			var text = $(this).siblings('.blurb').children('.text').children().text();
			//alert(text);
			var intro = $(this).siblings('.blurb').children('.dynamic_info').text();
			$(this).toggleClass('selected');
			$(this).siblings('.right, .left').toggleClass('selected');
			if(text == 'HIDE TEXT') {
				$(this).siblings('.blurb').children('.text').children('.hide_show').text('SHOW TEXT');
				$(this).siblings('.blurb').children('.dynamic_blurb').hide();
				$(this).siblings('.blurb').children('.dynamic_info').hide();
				$(this).siblings('.blurb').children('.small_intro').show();
				$(this).removeClass('selected');
				/*
				if ($(this).hasClass('left')) {
					$(this).siblings('.right').removeClass('selected');
				}
				else {
					$(this).siblings('.left').removeClass('selected');
				}
				*/
			}
			else {
				$(this).siblings('.blurb').children('.text').children('.hide_show').text('HIDE TEXT');
				$(this).siblings('.blurb').children('.dynamic_blurb').show().css('display','block');	
				$(this).siblings('.blurb').children('.dynamic_info').show();
				$(this).siblings('.blurb').children('.small_intro').hide();
				$(this).addClass('selected');
				/*
				if ($(this).hasClass('left')) {	
					$(this).siblings('.right').addClass('selected');
				}
				else {
					$(this).siblings('.left').addClass('selected');
				}
				*/
			}
		});


		$('.text').click(function(){
			var intro = $(this).siblings('.dynamic_info').text();
			var text = $(this).text();		
			if(text == 'HIDE TEXT') {
				$(this).children('.hide_show').text('SHOW TEXT');
				$(this).siblings('.dynamic_blurb').hide();
				$(this).siblings('.dynamic_info').hide();
				$(this).siblings('.small_intro').show();
				$(this).parent().siblings('.left').removeClass('selected');
				$(this).parent().siblings('.right').removeClass('selected');
			}
			else {
				$(this).children('.hide_show').text('HIDE TEXT');
				$(this).siblings('.dynamic_blurb').show().css('display','block');	
				$(this).siblings('.dynamic_info').show();
				$(this).siblings('.small_intro').hide();
				$(this).parent().siblings('.left').addClass('selected');
				$(this).parent().siblings('.right').addClass('selected');
			}

			
		});



	//Minor

		$('.no_hover').click(function(){
			$('.no_hover').removeClass('selected');
		});


		$('.pillar_icon_minor').click(function() {
			if ($(this).hasClass('selected')) {
				$(this).parent().siblings('.bridge_base').html('<img src="/img/Starma-Astrology-Stairs.png">');
			}
			else {
				$(this).parent().siblings('.bridge_base').html('<img src="img/Starma-Astrology-StairsON.png">');
			}
			$(this).parent().siblings().children('.pillar_icon_minor').not(this).removeClass('selected');
			$(this).toggleClass('selected');
			if ($(this).parent().hasClass('pillar')) {
				$(this).parent().toggleClass('pillar_arrow');
				$(this).parent().siblings().removeClass('pillar_arrow pillar_broken_arrow');
			}
			else {
				$(this).parent().toggleClass('pillar_broken_arrow');
				$(this).parent().siblings().removeClass('pillar_arrow pillar_broken_arrow');
			}
			var classes = $(this).children().attr('class');
			var index = classes[24];	//index of the to_leg(n)
			if ($(this).parent().siblings().children('.add_arrow_top').children('span').hasClass(index)) {
				$(this).parent().siblings().children('.add_arrow_top').children('span').removeClass();
				if($(this).hasClass('L')) {
					$(this).parent().siblings().children('.add_arrow_top').hide();
				}
				else {
					$(this).parent().siblings().children('.add_arrow_top').hide();
				}
			}
			else {
				$(this).parent().siblings().children('.add_arrow_top').children('span').removeClass();
				$(this).parent().siblings().children('.add_arrow_top').children('span').addClass(index);
				if ($(this).hasClass('L')) {
					$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL1');
					$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL2');
					$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL3');
					$(this).parent().siblings().children('.add_arrow_top').addClass('arrow_topR');
					$(this).parent().siblings().children('.arrow_topR').show();
				
					if($(this).children().hasClass('to_leg1')) {
						$(this).parent().siblings().children('.add_arrow_top').css('width', 491);
					}
					if($(this).children().hasClass('to_leg2')) {
						$(this).parent().siblings().children('.add_arrow_top').css('width', 403);
					}
					if($(this).children().hasClass('to_leg3')) {
						$(this).parent().siblings().children('.add_arrow_top').css('width', 315);
					}
				}
				else {
					$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topR');
					if($(this).children().hasClass('to_leg6')) {
						$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL1');
						$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL2');
						$(this).parent().siblings().children('.add_arrow_top').addClass('arrow_topL3');
						$(this).parent().siblings().children('.arrow_topL3').show();
						$(this).parent().siblings().children('.add_arrow_top').css('width', 495);
					}
					if($(this).children().hasClass('to_leg5')) {
						$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL1');
						$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL3');
						$(this).parent().siblings().children('.add_arrow_top').addClass('arrow_topL2');
						$(this).parent().siblings().children('.arrow_topL2').show();
						$(this).parent().siblings().children('.add_arrow_top').css('width', 409);
					}
					if($(this).children().hasClass('to_leg4')) {
						$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL2');
						$(this).parent().siblings().children('.add_arrow_top').removeClass('arrow_topL3');
						$(this).parent().siblings().children('.add_arrow_top').addClass('arrow_topL1');
						$(this).parent().siblings().children('.arrow_topL1').show();
						$(this).parent().siblings().children('.add_arrow_top').css('width', 317);
					}
				}
			}
			//alert(index);
			
		});

		$('.to_leg1').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
			$(this).parent().parent().siblings('.left').addClass('no_hover');
				if($(this).parent('.pillar_icon_minor').hasClass('selected')) {
					$(this).parent().parent().siblings('.right').removeClass('selected');
					$(this).parent().parent().siblings('.right').addClass('no_hover');
				}
				else {
					$(this).parent().parent().siblings('.right').addClass('selected');
					$(this).parent().parent().siblings('.right').removeClass('no_hover');
				}
			$(this).parent().parent().siblings('.leg1').toggle();
			$(this).parent().parent().siblings('.leg2').hide();
			$(this).parent().parent().siblings('.leg3').hide();
			$(this).parent().parent().siblings('.leg4').hide();
			$(this).parent().parent().siblings('.leg5').hide();
			$(this).parent().parent().siblings('.leg6').hide();
		});

		$('.to_leg2').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
			$(this).parent().parent().siblings('.left').addClass('no_hover');
				if($(this).parent('.pillar_icon_minor').hasClass('selected')) {
					$(this).parent().parent().siblings('.right').removeClass('selected');
					$(this).parent().parent().siblings('.right').addClass('no_hover');
				}
				else {
					$(this).parent().parent().siblings('.right').addClass('selected');
					$(this).parent().parent().siblings('.right').removeClass('no_hover');
				}
			//$('.no_hover').removeClass('selected');
			//$('.right').addClass('selected');
			$(this).parent().parent().siblings('.leg2').toggle();
			$(this).parent().parent().siblings('.leg1').hide();
			$(this).parent().parent().siblings('.leg3').hide();
			$(this).parent().parent().siblings('.leg4').hide();
			$(this).parent().parent().siblings('.leg5').hide();
			$(this).parent().parent().siblings('.leg6').hide();
		});

		$('.to_leg3').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
			$(this).parent().parent().siblings('.left').addClass('no_hover');
				if($(this).parent('.pillar_icon_minor').hasClass('selected')) {
					$(this).parent().parent().siblings('.right').removeClass('selected');
					$(this).parent().parent().siblings('.right').addClass('no_hover');
				}
				else {
					$(this).parent().parent().siblings('.right').addClass('selected');
					$(this).parent().parent().siblings('.right').removeClass('no_hover');
				}
			//$('.no_hover').removeClass('selected');
			//$('.right').addClass('selected');
			$(this).parent().parent().siblings('.leg3').toggle();
			$(this).parent().parent().siblings('.leg1').hide();
			$(this).parent().parent().siblings('.leg2').hide();
			$(this).parent().parent().siblings('.leg4').hide();
			$(this).parent().parent().siblings('.leg5').hide();
			$(this).parent().parent().siblings('.leg6').hide();
		});

		$('.to_leg4').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
			$(this).parent().parent().siblings('.right').addClass('no_hover');
				if($(this).parent('.pillar_icon_minor').hasClass('selected')) {
					$(this).parent().parent().siblings('.left').removeClass('selected');
					$(this).parent().parent().siblings('.left').addClass('no_hover');
				}
				else {
					$(this).parent().parent().siblings('.left').addClass('selected');
					$(this).parent().parent().siblings('.left').removeClass('no_hover');
				}
			//$('.no_hover').removeClass('selected');
			//$('.left').addClass('selected');
			$(this).parent().parent().siblings('.leg4').toggle();
			$(this).parent().parent().siblings('.leg2').hide();
			$(this).parent().parent().siblings('.leg3').hide();
			$(this).parent().parent().siblings('.leg1').hide();
			$(this).parent().parent().siblings('.leg5').hide();
			$(this).parent().parent().siblings('.leg6').hide();
		});

		$('.to_leg5').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
			$(this).parent().parent().siblings('.right').addClass('no_hover');
				if($(this).parent('.pillar_icon_minor').hasClass('selected')) {
					$(this).parent().parent().siblings('.left').removeClass('selected');
					$(this).parent().parent().siblings('.left').addClass('no_hover');
				}
				else {
					$(this).parent().parent().siblings('.left').addClass('selected');
					$(this).parent().parent().siblings('.left').removeClass('no_hover');
				}
			//$('.no_hover').removeClass('selected');
			//$('.left').addClass('selected');
			$(this).parent().parent().siblings('.leg5').toggle();
			$(this).parent().parent().siblings('.leg2').hide();
			$(this).parent().parent().siblings('.leg3').hide();
			$(this).parent().parent().siblings('.leg4').hide();
			$(this).parent().parent().siblings('.leg1').hide();
			$(this).parent().parent().siblings('.leg6').hide();
		});


		$('.to_leg6').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
			$(this).parent().parent().siblings('.right').addClass('no_hover');
				if($(this).parent('.pillar_icon_minor').hasClass('selected')) {
					$(this).parent().parent().siblings('.left').removeClass('selected');
					$(this).parent().parent().siblings('.left').addClass('no_hover');
				}
				else {
					$(this).parent().parent().siblings('.left').addClass('selected');
					$(this).parent().parent().siblings('.left').removeClass('no_hover');
				}
			//$('.no_hover').removeClass('selected');
			//$('.left').addClass('selected');
			$(this).parent().parent().siblings('.leg6').toggle();
			$(this).parent().parent().siblings('.leg2').hide();
			$(this).parent().parent().siblings('.leg3').hide();
			$(this).parent().parent().siblings('.leg4').hide();
			$(this).parent().parent().siblings('.leg5').hide();
			$(this).parent().parent().siblings('.leg1').hide();
		});


//POST MINOR COMPARE SUPPORT FOR-----------------------------------------------

	$('.mc').click(function(){
		$('.mc').removeClass('selected');
		$('.pillar_icon_minor, .left, .right').removeClass('selected');
		$('.pillar').removeClass('pillar_arrow');
		$('.pillar_broken').removeClass('pillar_broken_arrow');
		$('.blurb_supporting').hide();
		$('.add_arrow_top').hide();
		$('.bridge_base').html('<img src="/img/Starma-Astrology-Stairs.png">');
		var mc = $(this).children('input').val();
		if (mc == 0) {
			$('#mc_sun').hide();
			$('#mc_moon').hide();
			$('#mc_venus').hide();
			$('.mc_rising').addClass('selected');
			$('#mc_rising').fadeIn(300);
		}
		if (mc == 1) {
			$('#mc_rising').hide();
			$('#mc_moon').hide();
			$('#mc_venus').hide();
			$('.mc_sun').addClass('selected');
			$('#mc_sun').fadeIn(300);
		}
		if (mc == 2) {
			$('#mc_rising').hide();
			$('#mc_sun').hide();
			$('#mc_venus').hide();
			$('.mc_moon').addClass('selected');
			$('#mc_moon').fadeIn(300);
		}
		if (mc == 3) {
			$('#mc_rising').hide();
			$('#mc_sun').hide();
			$('#mc_moon').hide();
			$('.mc_venus').addClass('selected');
			$('#mc_venus').fadeIn(300);
		}
	});

	/*
	$('.mc').click(function(){
		$('#mc_results').html('<div><img src="/js/ajax_loader_sign_up.gif" /></div>');
		var data = { 'mc' 			: $(this).children('input').val(),
					 'chart_id1' 	: $('#chart_id1').val(),
					 'chart_id2' 	: $('#chart_id2').val()
					};

		$.ajax({
			method : 'POST',
			url: '/chat/minor_compare_submit.php',
			data: data,
			dataType: 'json'
		})
		.done(function(data){
			if (data.errors) {
				if (data.errors.mc) {

				}
				if (data.errors.chart_id1) {
					
				}
				if (data.errors.chart_id2) {
					
				}
			}
			if (data.results) {
				alert('con_x: ' + data.con_x + ' con_y: ' + data.con_y + ' poi_id_a: ' + data.poi_id_a + ' poi_id_b: ' + data.poi_id_b + ' rel_id2: ' + data.relationship_id2 + ' chart_id1: ' + data.chart_id1 + ' chart_id2: ' + data.chart_id2 + ' blurb: ' + data.blurb);
				$('#mc_results').html(data.results);
			}
		});
	});
	*/
});





