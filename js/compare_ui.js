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
		
	//Major
		$('.text').click(function(){
			//$(this).toggleClass('hide show');
			var intro = $(this).siblings('.dynamic_info').text();
			var text = $(this).text();		
			if(text == 'HIDE TEXT') {
				$(this).children('.hide_show').text('SHOW TEXT');
				//$(this).parent().css('height', 'auto');
				$(this).siblings('.dynamic_blurb').hide();
				$(this).siblings('.dynamic_info').hide();
				$(this).siblings('.small_intro').show();
			}
			else {
				$(this).children('.hide_show').text('HIDE TEXT');
				$(this).siblings('.dynamic_blurb').show().css('display','block');
				//$(this).parent().css('height', 'auto');	
				$(this).siblings('.dynamic_info').show();
				$(this).siblings('.small_intro').hide();
			}

					//var x = 0;
					//$('.blurb').each(function(x, autoHeight) {
						//$(this).animate({height : autoHeight[x]}, 200);
						//x++;
					//});
			
		});



	//Minor
		//$('.blurb_supporting').hide();

		$('.pillar_icon_minor').click(function() {
			$(this).parent().siblings().children('.pillar_icon_minor').not(this).removeClass('selected');
			$(this).toggleClass('selected');
		});

		$('.to_leg1').click(function(){
			$(this).parent().parent().siblings('.right, .left').removeClass('selected');
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





