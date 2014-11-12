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
	});

	$('#ct2_done').click(function(){
		$('#msg_sheen_ct2').fadeOut(300);
		$('#western_circle').fadeOut(300);
		$('#msg_sheen_ct3'). fadeIn(300);
		$('#why_vedic_circle').fadeIn(300);
	});

	$('#ct3_done').click(function(){
		$('#msg_sheen_ct3').fadeOut(300);
		$('#why_vedic_circle').fadeOut(300);
		$('#msg_sheen_ct4'). fadeIn(300);
	});


});