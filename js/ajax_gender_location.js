$(document).ready(function() {


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

//--------------#ZIP FUNCTIONALITY 

$('#zip').on('keyup blur', function(){

	//var intRegex = /^\d{5}$/;
        
        if ($('#zip').val().length == 5) {
          	$.ajax({
		        type  		: 'GET',
                cache 		: false,
	            url   		: '/chat/process_all.php',
                data    	: {  
		   						'function': 'run_zip',
								'zip': $('#zip').val()                                       					
				},
	            dataType	: 'json',
	        })
           	.done(function(data){
                if (data.title_js) {                               
    				$('#location_verification').html(data.title_js).removeClass('zip_err');
                }
                else {
                    $('#location_verification').text('Unknown zip code').addClass('zip_err');  
                } 
                                                                    
			});
		}

});


//--------------REMOVE RED BORDERS
    $('#gender_select').on('change', function(){
		if ($('#gender_select').val() != 'none') {
			$('#gl_gender_error').hide().text('');
			$('#gender_select').css('border', '2px solid black');
		}
	});

	$('#zip').on('keyup', function(){
		$('#zip').css('border', '2px solid black');
		$('#gl_zip_error').hide().text('');
	});

    $('#country_id').on('change', function(){
    	if ($('#country_id').val() !== 0) {
			$('#country_id').css('border', '2px solid black');
			$('#gl_cid_error').hide().text('');
		}
		if ($('#country_id').val() == 236) {
			$('#city').css('border', '2px solid black');
			$('#gl_city_error').hide().text('');
		}
		if ($('#country_id').val() !== 236) {
			$('#zip').css('border', '2px solid black');
			$('#gl_zip_error').hide().text('');
		}
	});

    $('#city').on('keyup', function(){
		$('#city').css('border', '2px solid black');
		$('#gl_city_error').hide().text('');
	});

	


//------------- ERROR EXP
	$('#gl_gender_error').mouseenter(function(){
		$('#gl_err_gender_exp').show();
	});
	$('#gl_gender_error').mouseleave(function(){
		$('#gl_err_gender_exp').hide();
	});

	$('#gl_cid_error').mouseenter(function(){
		$('#gl_err_cid_exp').show();
	});
	$('#gl_cid_error').mouseleave(function(){
		$('#gl_err_cid_exp').hide();
	});

	$('#gl_city_error').mouseenter(function(){
		$('#gl_err_city_exp').show();
	});
	$('#gl_city_error').mouseleave(function(){
		$('#gl_err_city_exp').hide();
	});

	$('#gl_zip_error').mouseenter(function(){
		$('#gl_err_zip_exp').show();
	});
	$('#gl_zip_error').mouseleave(function(){
		$('#gl_err_zip_exp').hide();
	});


//$('#next').click(function(event) {
	$('#gender_location_form').submit(function(event){
		/*
		if ($('#gender_select').val() == 'none') {
			$('#gender_error').show();
			event.preventDefault();
		}
		if ($('#city').is(':visible')) {
			if($('#city').val() == '') {
				$('#city').css('border', '1px solid #C82923');
				$('#city').on('keyup', function(){
					$('#city').css('border', '1px solid #d1d1d1');
				});
				event.preventDefault();
			}
		}
		*/
	$('#step').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
		if ($('#city').is(':visible')) {
			var data = {
				'gender'      :  $('#gender_select').val(),
				'country_id'  :  $('#country_id').val(),
				'city'        :  $('#city').val(),
			};
		}
		if ($('#zip').is(':visible')) {
			var data = {
				'gender'      :  $('#gender_select').val(),
				'country_id'  :  $('#country_id').val(),
				'zip'         :  $('#zip').val(),
			};
		}

		$.ajax({
			type      : 'POST',
			url       : '/chat/ajax_gender_location.php',
			data      : data,
			dataType  : 'json',
		})
		.done(function(data){
			if (data.country) {
				alert(data.country);
			}
			//alert(data);
			if (data.errors) {
				$('#step').html('').text('1 / 3');
				if (data.errors.country_id) {
					//alert(data.errors.country);
					$('#country_id').css('border', '2px solid #C82923');
					$('#gl_cid_error').show().text('?');
					$('#gl_err_cid_exp').text(data.errors.country_id);
				}
				if (data.errors.zip) {
					//alert(data.errors.zip);
					$('#zip').css('border', '2px solid #C82923');
					$('#gl_zip_error').show().text('?');
					$('#gl_err_zip_exp').text(data.errors.zip);
				}
				if (data.errors.city) {
					$('#city').css('border', '2px solid #C82923');
					$('#gl_city_error').show().text('?');
					$('#gl_err_city_exp').text(data.errors.city);
				}
				if (data.errors.geocode_city) {
					$('#city').css('border', '2px solid #C82923');
					$('#gl_city_error').show().text('?');
					$('#gl_err_city_exp').text(data.errors.geocode_city);
					//alert(data.errors.geocode);
					//alert(data.errors.test);
				}
				if (data.errors.geocode_zip) {
					$('#zip').css('border', '2px solid #C82923');
					$('#gl_zip_error').show().text('?');
					$('#gl_err_zip_exp').text(data.errors.geocode_zip);
					//alert(data.errors.geocode);
					//alert(data.errors.test);
				}
				if (data.errors.gender) {
					//alert(data.errors.gender);
					$('#gender_select').css('border', '2px solid #C82923');
					$('#gl_gender_error').show().text('?');
					$('#gl_err_gender_exp').text(data.errors.gender);
				}
			}
			if (data.success) {
				//$('#step').html('').text('1 / 3');
				//alert(data.url + ', ' + data.loc + ', ' + data.state_id);
				window.location.assign('/' + data.url);
			}
		});

		event.preventDefault();

	});
//});

});