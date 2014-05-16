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


		$('.to_leg1').click(function(){
			$(this).parent().siblings('.leg1').toggle();
			$(this).parent().siblings('.leg2').hide();
			$(this).parent().siblings('.leg3').hide();
			$(this).parent().siblings('.leg4').hide();
			$(this).parent().siblings('.leg5').hide();
			$(this).parent().siblings('.leg6').hide();
		});

		$('.to_leg2').click(function(){
			$(this).parent().siblings('.leg2').toggle();
			$(this).parent().siblings('.leg1').hide();
			$(this).parent().siblings('.leg3').hide();
			$(this).parent().siblings('.leg4').hide();
			$(this).parent().siblings('.leg5').hide();
			$(this).parent().siblings('.leg6').hide();
		});

		$('.to_leg3').click(function(){
			$(this).parent().siblings('.leg3').toggle();
			$(this).parent().siblings('.leg1').hide();
			$(this).parent().siblings('.leg2').hide();
			$(this).parent().siblings('.leg4').hide();
			$(this).parent().siblings('.leg5').hide();
			$(this).parent().siblings('.leg6').hide();
		});

		$('.to_leg4').click(function(){
			$(this).parent().siblings('.leg4').toggle();
			$(this).parent().siblings('.leg2').hide();
			$(this).parent().siblings('.leg3').hide();
			$(this).parent().siblings('.leg1').hide();
			$(this).parent().siblings('.leg5').hide();
			$(this).parent().siblings('.leg6').hide();
		});

		$('.to_leg5').click(function(){
			$(this).parent().siblings('.leg5').toggle();
			$(this).parent().siblings('.leg2').hide();
			$(this).parent().siblings('.leg3').hide();
			$(this).parent().siblings('.leg4').hide();
			$(this).parent().siblings('.leg1').hide();
			$(this).parent().siblings('.leg6').hide();
		});


		$('.to_leg6').click(function(){
			$(this).parent().siblings('.leg6').toggle();
			$(this).parent().siblings('.leg2').hide();
			$(this).parent().siblings('.leg3').hide();
			$(this).parent().siblings('.leg4').hide();
			$(this).parent().siblings('.leg5').hide();
			$(this).parent().siblings('.leg1').hide();
		});




});





