$(document).ready(function(){

	//var autoHeight = [];
	//	$('.blurb').each(function(){ 
	//		var height = $(this).height()
	//		autoHeight.push(height);
	//		return autoHeight;				
	//	});
		//alert(autoHeight);
		
	//Major
		$('.text').click(function(){
			//$(this).toggleClass('hide show');
			var intro = $(this).siblings('.dynamic_info').text();
			var text = $(this).text();		
			if(text == 'Hide Text') {
				$(this).children('.hide_show').text('Show Text');
				//$(this).parent().css('height', 'auto');
				$(this).siblings('.dynamic_blurb').hide();
				$(this).siblings('.dynamic_info').text(intro + '..');
			}
			else {
				$(this).children('.hide_show').text('Hide Text');
				$(this).siblings('.dynamic_blurb').show();
				//$(this).parent().css('height', 'auto');	
				$(this).siblings('.dynamic_info').text(intro.slice(0, -2));
			}

					//var x = 0;
					//$('.blurb').each(function(x, autoHeight) {
						//$(this).animate({height : autoHeight[x]}, 200);
						//x++;
					//});
			
		});



	//Minor
		$('.blurb_supporting').hide();


		$('.to_leg1').click(function(){
			$(this).parent().siblings('.leg1').toggle();
			$(this).parent().siblings('.leg2').hide();
			$(this).parent().siblings('.leg3').hide();
		});

		$('.to_leg2').click(function(){
			$(this).parent().siblings('.leg2').toggle();
			$(this).parent().siblings('.leg1').hide();
			$(this).parent().siblings('.leg3').hide();
		});

		$('.to_leg3').click(function(){
			$(this).parent().siblings('.leg3').toggle();
			$(this).parent().siblings('.leg1').hide();
			$(this).parent().siblings('.leg2').hide();
		});








});





