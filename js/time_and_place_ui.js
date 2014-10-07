$(document).ready(function(){

//------------CITY VS ZIP
	if ($('#country_id').val() !== 236) {
		$('#js_zip_div').hide();
    $('#location_verification').css('visibility', 'hidden'); 
    $('#js_city_div').show();
  }
  if ($('#country_id').val() == 236) {
          $('#js_zip_div').show();
          $('#location_verification').css('visibility', 'visible');
          $("#js_city_div").hide();
          $('#city').val('');        
  }

	$('#country_id').change(function(event) { 
    $('#country').css('border', '1px solid #d1d1d1');
    $('#tp_cid_error').hide().text('');
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

  $('#zip').on('keyup', function(){
    $('#zip').css('border', '1px solid #d1d1d1');
    $('#tp_zip_error').hide().text('');
  });

  $('#city').on('keyup', function(){
    $('#city').css('border', '1px solid #d1d1d1');
    $('#tp_city_error').hide().text('');
  });

//-------------------SHOWING ERR EXP
  $('#tp_cid_error').mouseenter(function(){
    $('#tp_err_cid_exp').show();
  });
  $('#tp_cid_error').mouseleave(function(){
    $('#tp_err_cid_exp').hide();
  });

  $('#tp_city_error').mouseenter(function(){
    $('#tp_err_city_exp').show();
  });
  $('#tp_city_error').mouseleave(function(){
    $('#tp_err_city_exp').hide();
  });

  $('#tp_zip_error').mouseenter(function(){
    $('#tp_err_zip_exp').show();
  });
  $('#tp_zip_error').mouseleave(function(){
    $('#tp_err_zip_exp').hide();
  });

});