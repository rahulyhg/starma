$(document).ready(function() {

	$('$geneder_select').on('change', function() {
		$('$geneder_select').css('border-color', 'black');
	});

	$('s_vars_submit').click(function(event){
		if($('#geneder_select').val() == 'none') {
			event.preventDefault();
			$('$geneder_select').css('border-color', '#C82923');
		}
	});


});