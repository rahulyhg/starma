$(document).ready(function(){

//------------CITY VS ZIP
	if ($('#country_id').val() !== 236) {
		$('#js_zip_div').hide();
    	$('#location_verification').css('visibility', 'hidden'); 
    	$('#js_city_div').show();
    }

	$('#country_id').change(function(event) { 
      	if ($('#country_id').val() == 236) {
        	$('#js_zip_div').show();
        	$('#location_verification').css('visibility', 'visible');
        	$("#js_city_div").hide();
        	$('#city').val('');
        
      	}
      	else {
        	$('#js_zip_div').hide();
        	$('#location_verification').css('visibility', 'hidden');
        	$('#js_city_div').show();
        	$('#zip').val('');
      	}
    });

});