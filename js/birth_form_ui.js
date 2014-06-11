$(document).ready(function(){
	
	//$('input[type=submit]').prop('disabled', true);

	$('select[name=gender]').on('change', function() {
		if($('select[name=gender]').val() != 'none') {
			$('.gender_validation').hide().text('*Please select a gender').css('color','red');
		}
	});

	$('input[name=time_unknown]').click(function(){
		$('#hour_time').toggleClass('grayed_out');
		$('#minute_time').toggleClass('grayed_out');
		$('#meridiem_time').toggleClass('grayed_out');
		$('#interval').toggleClass('grayed_out');
	});

	$('input[type=submit]').click(function(event){
		if($('select[name=gender]').val() == 'none') {
			event.preventDefault();
			$('.gender_validation').show().text('*Please select a gender').css('color','red');
		}
	})


});