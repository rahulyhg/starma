$(document).ready(function(){

	if ($('.chart_pop1').length) {
		$('.chart_pop1').show();
	}
	$('#ct1_done').click(function(){
		$('.chart_pop1').slideFadeToggle();
	});

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



});