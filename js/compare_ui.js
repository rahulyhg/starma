$(document).ready(function(){

	//var autoHeight = [];
	//	$('.blurb').each(function(){ 
	//		var height = $(this).height()
	//		autoHeight.push(height);
	//		return autoHeight;				
	//	});
		//alert(autoHeight);
		
		
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
});