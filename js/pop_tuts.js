$(document).ready(function(){

	if ($('.chart_pop').length) {
		$('.chart_pop').show();
	}
	/*
	$('#ct1_done').click(function(){
		$('.chart_pop').slideFadeToggle();
	});
	*/

	$('#clickMe').click(function(event){
		if($('#cfc').prop('checked')) {
			var data = {'cfc' : 1};
		}
		if(!$('#cfc').prop('checked')) {
			var data = {'cfc' : 0};
		}

			$.ajax({
				type      : 'POST',
				url       : '/chat/pop_tuts.php',
				data      : data,
				dataType  : 'json',
			})
			.done(function(data){
				if (data.errors) {
					if (data.errors.set) {
						$('.cfv_err').text(data.errors.set);
					}
				}
				if (data.success) {
					//alert(data.cfv);
					$('#cfv').text(data.cfv);
				}
			}); 
	});



//CHART POP TUTS------------------------------

	$('#ct1_done').click(function(){
		$('#msg_sheen_ct1').fadeOut(300);
		$('#msg_sheen_ct2').fadeIn(300);
		$('#western_circle').fadeIn(300);
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.45);
	});

	$('#ct2_done').click(function(){
		$('#msg_sheen_ct2').fadeOut(300);
		$('#western_circle').fadeOut(300);
		$('#msg_sheen_ct3'). fadeIn(300);
		$('#why_vedic_circle').fadeIn(300);
	});

	$('#ct3_done').click(function(){
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.71);
		$('#msg_sheen_ct3').fadeOut(300);
		$('#why_vedic_circle').fadeOut(300);
		$('#msg_sheen_ct4'). fadeIn(300);
	});

	$('#ct4_done').click(function(){
		$('#msg_sheen_ct4').fadeOut(300);
		$('#msg_sheen_ct5').fadeIn(300);
		$('#poi_circle_left, #poi_circle_right').fadeIn(300);
	});

	$('#ct5_done').click(function(){
		$('#msg_sheen_ct5').fadeOut(300);
		$('#poi_circle_left, #poi_circle_right').fadeOut(300);
		$('.chart_pop').fadeOut(300);

		var data = {'chart_flag' : 0};
		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  data,
			dataType 	: 'json',
		})
		.done(function(data){
			if (data.errors) {
				console.log(data.errors.chart_flag);
			}
			if (data.chart_flag) {
				console.log(data.chart_flag);
			}
		});
	});


//COMPARE POPTUTS -------------------------------------------

if ($('.compare_pop').length) {
		$('.compare_pop').show();
	}
	
	$('#cot1_done').click(function(){
		$('#msg_sheen_cot1').fadeOut(300);
		$('#msg_sheen_cot2').fadeIn(300);
		$('#western_circle').fadeIn(300);
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.45);
	});

	$('#cot2_done').click(function(){
		$('#msg_sheen_cot2').fadeOut(300);
		//$('#western_circle').fadeOut(300);
		$('#msg_sheen_cot3'). fadeIn(300);
		//$('#why_vedic_circle').fadeIn(300);
	});

	$('#cot3_done').click(function(){
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.71);
		$('#msg_sheen_cot3').fadeOut(300);
		//$('#why_vedic_circle').fadeOut(300);
		$('#msg_sheen_cot4'). fadeIn(300);
	});

	$('#cot4_done').click(function(){
		$('#msg_sheen_cot4').fadeOut(300);
		$('#msg_sheen_cot5').fadeIn(300);
		//$('#poi_circle_left, #poi_circle_right').fadeIn(300);
	});

	$('#cot5_done').click(function(){
		$('#msg_sheen_cot5').fadeOut(300);
		//$('#poi_circle_left, #poi_circle_right').fadeOut(300);
		$('.compare_pop').fadeOut(300);

		var data = {'compare_flag' : 0};
		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  data,
			dataType 	: 'json',
		})
		.done(function(data){
			if (data.errors) {
				console.log(data.errors.compare_flag);
			}
			if (data.compare_flag) {
				console.log(data.compare_flag);
			}
		});
	});


});