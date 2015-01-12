$(document).ready(function(){

  $('#step').html('').text('');

//------------CITY VS ZIP
	if ($('#country_id').val() !== 236) {
		//$('#js_zip_div').hide();
    //$('#location_verification').css('visibility', 'hidden'); 
    //$('#js_city_div').show();
    $('#city').attr('placeholder', 'City');
  }
  if ($('#country_id').val() == 236) {
          //$('#js_zip_div').show();
          //$('#location_verification').css('visibility', 'visible');
          //$("#js_city_div").hide();
          //$('#city').val(''); 
      $('#city').attr('placeholder', 'I.e. San Francisco, CA');       
  }

/*
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
*/

$('#country_id').change(function(event) { 
  if ($('#country_id').val() !== 236) {
    $('#city').attr('placeholder', 'City');
  }
  if ($('#country_id').val() == 236) {
    $('#city').attr('placeholder', 'i.e. San Francisco, CA');       
  }
  $('#country>select').css('border', '2px solid black');
  $('#tp_cid_error').hide();
  $('#tp_cid_error_h').hide();
  $('#city').val('');
});

  $('#city').on('keyup', function(){
    $('#city').css('border', '2px solid black');
    $('#tp_city_error').hide();
    $('#tp_city_error_h').hide();
  });

//-------------------SHOWING ERR EXP
  $('#tp_cid_error').mouseenter(function(){
    $('#tp_err_cid_exp').show();
  });
  $('#tp_cid_error').mouseleave(function(){
    $('#tp_err_cid_exp').hide();
  });
  $('#tp_cid_error_h').mouseenter(function(){
    $('#tp_err_cid_exp').show();
  });
  $('#tp_cid_error_h').mouseleave(function(){
    $('#tp_err_cid_exp').hide();
  });

  $('#tp_city_error').mouseenter(function(){
    $('#tp_err_city_exp').show();
  });
  $('#tp_city_error').mouseleave(function(){
    $('#tp_err_city_exp').hide();
  });
  $('#tp_city_error_h').mouseenter(function(){
    $('#tp_err_city_exp').show();
  });
  $('#tp_city_error_h').mouseleave(function(){
    $('#tp_err_city_exp').hide();
  });

  $('#tp_zip_error').mouseenter(function(){
    $('#tp_err_zip_exp').show();
  });
  $('#tp_zip_error').mouseleave(function(){
    $('#tp_err_zip_exp').hide();
  });

//--------------------------HELP LINK FUNCTIONS
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

  //$('#next').click(function() {
    $('#next').click(function(){
      //$('#step').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
      $('#step').text('One Moment Please...');
      if($('#country_id').val() != 0 && $('#city').val() != '') {
        mixpanel.track('Time and Place', {
          'city'         : $('#city').val(),
          'country_id'   : $('#country_id').val(),
          'hour'         : $('#hour_time').val(),
          'minute'       : $('#minute_time').val(),
          'meridiem'     : $('#meridiem_time').val(),
          'interval'     : $('#interval').val(),
          'time_unknown' : $('#time_unknown').val(),
          'TP From'      : 'TP Popup'
        });
      }
    });
    
    $('#birth_info_form').submit(function(event){
      if($('#country_id').val() == 0 || $('#city').val() == '') {
        event.preventDefault();
        if ($('#country_id').val() == 0) {
          $('#country_id').css('border', '2px solid #C82923');
          $('#tp_cid_error_h').show();
        }
        if ($('#city').val() == '') {
          $('#city').css('border', '2px solid #C82923');
          $('#tp_city_error_h').show();
        }
      }
    });

    $('#next_no_chart').click(function(){
      //$('#step').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
      //$('#step').text('One Moment Please...');
      if($('.country_id_p').val() != 0 && $('.city_p').val() != '') {
        mixpanel.track('Time and Place', {
          'city'         : $('.city_p').val(),
          'country_id'   : $('.country_id_p').val(),
          'hour'         : $('.hour_time_p').val(),
          'minute'       : $('.minute_time_p').val(),
          'meridiem'     : $('.meridiem_time_p').val(),
          'interval'     : $('.interval_p').val(),
          'time_unknown' : $('.time_unknown_p').val(),
          'TP From'      : 'No Chart Profile'
        });
      }
    });

    $('#birth_info_form_chart_page').submit(function(event){
      if($('.country_id_p').val() == 0 || $('.city_p').val() == '') {
        event.preventDefault();
        if ($('.country_id_p').val() == 0) {
          $('.country_id_p').css('border', '2px solid #C82923');
          $('#tp_cid_error_h').show();
        }
        if ($('.city_p').val() == '') {
          $('.city_p').css('border', '2px solid #C82923');
          $('#tp_city_error_h').show();
        }
      }
    });

});