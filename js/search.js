$(document).ready(function() {

	$('#gender_select').on('change', function() {
		$('#gender_select').css('border-color', 'black');
	});

	$('#s_vars_submit').click(function(event){
		if($('#gender_select').val() == 'none') {
			event.preventDefault();
			$('#gender_select').css('border-color', '#C82923');
		}
	});


});