$(document).ready(function(){
	
	//$('input[type=submit]').prop('disabled', true);

	$('select[name=gender]').on('change', function() {
		if($('select[name=gender]').val() !== 'none') {
			$('.gender_validation').hide();
		}
	});

	/*
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
	*/

	$('input[type=submit]').click(function(event){
		if($('select[name=gender]').val() == 'none') {
			event.preventDefault();
			$('.gender_validation').show().text('<-').css('color','red');
		}
		if($('#birth_place_input_bar').val() == '') {
			event.preventDefault();
			$('.birth_place_validation').show().text('<-').css('color','red');
		}
	});

	$('#birth_place_input_bar').keyup(function() {
		$('.birth_place_validation').show().text('');
	});
	/*
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
*/

	$('#help_link').click(function(event) {
    	$('#time_unknown').val('1');  //Make sure to undo this on change!!!!!!!!!!!!!!!!!!!!
    	basicPopup('help_text_birth_time.php', 'Help Text', 'height=500,width=500,left=100,top=100,resizable=yes,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no, status=no, titlebar=no');
    	$('#interval').val('-1');
    	$('#hour_time').val('12');
    	$('#minute_time').val('00');
    	$('#second_time').val('00');
    	$('#meridiem_time').val('am');
    	$('#help_link').css('')
  	});
  	$('#interval').on('change', function(){
    	$('#time_unknown').val('0');
 	});

  	$('#hour_time').on('change', function(){
    	$('#time_unknown').val('0');
 	});

  	$('#minute_time').on('change', function(){
    	$('#time_unknown').val('0');
  	});

  	$('#meridiem_time').on('change', function(){
    	$('#time_unknown').val('0');
  	});

});