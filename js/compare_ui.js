$(document).ready(function(){

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
			$('#major').show();
			$('#minor').hide();
			$('#ruler').hide();
			$('#bonus').hide();
		});
		$('#minor_select').click(function(){
			$('.selector').removeClass('selected');
			$('#minor_select').addClass('selected');
			$('#minor').show();
			$('#major').hide();
			$('#ruler').hide();
			$('#bonus').hide();
		});
		$('#ruler_select').click(function(){
			$('.selector').removeClass('selected');
			$('#ruler_select').addClass('selected');
			$('#ruler').show();
			$('#major').hide();
			$('#minor').hide();
			$('#bonus').hide();
		});
		$('#bonus_select').click(function(){
			$('.selector').removeClass('selected');
			$('#bonus_select').addClass('selected');
			$('#bonus').show();
			$('#major').hide();
			$('#minor').hide();
			$('#ruler').hide();
		});

		
	//Major
		$('.text').click(function(){
			var intro = $(this).siblings('.dynamic_info').text();
			var text = $(this).text();		
			if(text == 'HIDE TEXT') {
				$(this).children('.hide_show').text('SHOW TEXT');
				$(this).siblings('.dynamic_blurb').hide();
				$(this).siblings('.dynamic_info').hide();
				$(this).siblings('.small_intro').show();
			}
			else {
				$(this).children('.hide_show').text('HIDE TEXT');
				$(this).siblings('.dynamic_blurb').show().css('display','block');	
				$(this).siblings('.dynamic_info').show();
				$(this).siblings('.small_intro').hide();
			}

			
		});



	//Minor



		$('.pillar_icon_minor').click(function() {
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
						$(this).parent().siblings().children('.add_arrow_top').css('width', 489);
					}
					if($(this).children().hasClass('to_leg2')) {
						$(this).parent().siblings().children('.add_arrow_top').css('width', 403);
					}
					if($(this).children().hasClass('to_leg3')) {
						$(this).parent().siblings().children('.add_arrow_top').css('width', 313);
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




});





