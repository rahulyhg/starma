$(document).ready(function(){
	
	//$('input[type=submit]').prop('disabled', true);

	$('select[name=gender]').on('change', function() {
		if($('select[name=gender]').val() != 'none') {
			$('.gender_validation').hide().text('*Please select a gender').css('color','red');
		}
	});


	if ($('input[name=time_unknown]').is(':checked')) {	
		$('#hour_time').addClass('grayed_out');
		$('#minute_time').addClass('grayed_out');
		$('#meridiem_time').addClass('grayed_out');
		$('#interval').addClass('grayed_out');
	}
	else {
		$('#hour_time').removeClass('grayed_out');
		$('#minute_time').removeClass('grayed_out');
		$('#meridiem_time').removeClass('grayed_out');
		$('#interval').removeClass('grayed_out');
	}

	$('input[type=submit]').click(function(event){
		if($('select[name=gender]').val() == 'none') {
			event.preventDefault();
			$('.gender_validation').show().text('Please select a gender').css('color','red');
		}
		if($('#birth_place_input_bar').val() == '') {
			event.preventDefault();
			$('.birth_place_validation').show().text('Enter birth place').css('color','red');
		}
	});

	$('#birth_place_input_bar').keyup(function() {
		$('.birth_place_validation').show().text('');
	});

	$('input[name=time_unknown]').click(function(){
		if ($('input[name=time_unknown]').is(':checked')) {	
			$('#hour_time').addClass('grayed_out');
			$('#minute_time').addClass('grayed_out');
			$('#meridiem_time').addClass('grayed_out');
			$('#interval').addClass('grayed_out');
		}
		else {
			$('#hour_time').removeClass('grayed_out');
			$('#minute_time').removeClass('grayed_out');
			$('#meridiem_time').removeClass('grayed_out');
			$('#interval').removeClass('grayed_out');
		}
	});

});