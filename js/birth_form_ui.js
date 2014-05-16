$(document).ready(function(){

	$('input[name=time_unknown]').click(function(){
		$('#hour_time').toggleClass('grayed_out');
		$('#minute_time').toggleClass('grayed_out');
		$('#meridiem_time').toggleClass('grayed_out');
		$('#interval').toggleClass('grayed_out');
	});

});