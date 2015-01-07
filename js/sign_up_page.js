$(document).ready(function(){


	//SHOW UPLOAD PHOTO FORM ON ERROR
	if ($('.p_err').length) {
		$('#upload_photo_form_sign_up').show();
	}

	//------------CITY VS ZIP
	if ($('#country_id').val() != 236) {
		$('#js_zip_div').hide();
    	$('#location_verification').hide(); 
    	$('#js_city_div').show();
    }

    if ($('#country_id').val() == 236) {
    	$('#js_city_div').hide();
		$('#js_zip_div').show();
    	$('#location_verification').show(); 
    }

	$('#country_id').change(function(event) { 
      	if ($('#country_id').val() == 236) {
        	$('#js_zip_div').show();
        	$('#location_verification').show();
        	$("#js_city_div").hide();
        	$('#city').val('');
        
      	}
      	else {
        	$('#js_zip_div').hide();
        	$('#location_verification').hide();
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
    				$('#location_verification').show().html(data.title_js).removeClass('zip_err');
                }
                else {
                    $('#location_verification').show().text('Unknown zip code').addClass('zip_err');  
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
    	if ($('#country_id').val() != 0) {
			$('#country_id').css('border', '2px solid black');
			$('#gl_cid_error').hide().text('');
		}
		if ($('#country_id').val() == 236) {
			$('#city').css('border', '2px solid black');
			$('#gl_city_error').hide().text('');
		}
		if ($('#country_id').val() != 236) {
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
	$('#gl_gender_error').click(function(){
		$('#gl_err_gender_exp').toggle();
	});

	$('#gl_cid_error').mouseenter(function(){
		$('#gl_err_cid_exp').show();
	});
	$('#gl_cid_error').mouseleave(function(){
		$('#gl_err_cid_exp').hide();
	});
	$('#gl_cid_error').click(function(){
		$('#gl_err_cid_exp').toggle();
	});

	$('#gl_city_error').mouseenter(function(){
		$('#gl_err_city_exp').show();
	});
	$('#gl_city_error').mouseleave(function(){
		$('#gl_err_city_exp').hide();
	});
	$('#gl_city_error').click(function(){
		$('#gl_err_city_exp').toggle();
	});

	$('#gl_zip_error').mouseenter(function(){
		$('#gl_err_zip_exp').show();
	});
	$('#gl_zip_error').mouseleave(function(){
		$('#gl_err_zip_exp').hide();
	});
	$('#gl_zip_error').click(function(){
		$('#gl_err_zip_exp').toggle();
	});


/*
//$('#next').click(function(event) {
	$('#gender_location_form').submit(function(event){

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
				mixpanel.track('Gender and Location', {
					'gender'   : data.gender,
					'location' : data.loc,
					'state_id' : data.state_id
				}, window.location.assign('/' + data.url));
				setTimeout(function(){ window.location.assign('/' + data.url); }, 500);
				//$('#step').html('').text('1 / 3');
				//alert(data.url + ', ' + data.loc + ', ' + data.state_id);
				//window.location.assign('/' + data.url);
			}
		});

		event.preventDefault();

	});
*/


$('.div_no_photo').click(function(){
	$('#sign_up_page').hide();
	$('#upload_photo_form_sign_up').show();
});


$('.incomplete').click(function(){
	$('#action_step').text('Please upload a photo');
});


//ERRORS EXP--------------

	$('#w_1_error').mouseenter(function(){
		$('#w_1_err_exp').show();
	});
	$('#w_1_error').mouseleave(function(){
		$('#w_1_err_exp').hide();
	});
	$('#w_1_error').click(function(){
		$('#w_1_err_exp').toggle();
	});
	$('#w_2_error').mouseenter(function(){
		$('#w_2_err_exp').show();
	});
	$('#w_2_error').mouseleave(function(){
		$('#w_2_err_exp').hide();
	});
	$('#w_2_error').click(function(){
		$('#w_2_err_exp').toggle();
	});
	$('#w_3_error').mouseenter(function(){
		$('#w_3_err_exp').show();
	});
	$('#w_3_error').mouseleave(function(){
		$('#w_3_err_exp').hide();
	});
	$('#w_3_error').click(function(){
		$('#w_3_err_exp').toggle();
	});
	$('#p_error').mouseenter(function(){
		$('#p_err_exp').show();
	});
	$('#p_error').mouseleave(function(){
		$('#p_err_exp').hide();
	});
	$('#p_error').click(function(){
		$('#p_err_exp').toggle();
	});


	$('#word_1').on('keyup', function(e){
		if (e.which != 9 && e.which != 13 && e.which != 16 && e.which != 17	&& e.which != 18) {
			$('#word_1').css('border', '2px solid black').removeClass('error');
			$('#w_1_error').hide().text('');
			$('#w_1_err_exp').hide().text('');
		}	
	});

	$('#word_2').on('keyup', function(e){
		if (e.which != 9 && e.which != 13 && e.which != 16 && e.which != 17	&& e.which != 18) {
			$('#word_2').css('border', '2px solid black').removeClass('error');
			$('#w_2_error').hide().text('');
			$('#w_2_err_exp').hide().text('');
		}
	});

	$('#word_3').on('keyup', function(e){
		if (e.which != 9 && e.which != 13 && e.which != 16 && e.which != 17	&& e.which != 18) {
			$('#word_3').css('border', '2px solid black').removeClass('error');
			$('#w_3_error').hide().text('');
			$('#w_3_err_exp').hide().text('');
		}
	});


//WORDS POST

	$('#word_1').on('blur', function() {
		$('#desc1').val($('#word_1').val());

		//clearInterval(timer_word_1);
		//timer_word_1 = setTimeout(function() {
			var word1_q = { 'word1_q' : $('#word_1').val()};

			$.post('/chat/sign_up_page.php', word1_q, function(data){
			
				if (data.errors) {
					$('#word_1').css('border', '2px solid #C82923').addClass('error');
					$('#w_1_error').show().text('?');
					$('#w_1_err_exp').text(data.errors);
				}
				else {
					$('#word_1').css('border', '2px solid black').removeClass('error');
					$('#w_1_error').hide().text('');
					$('#w_1_err_exp').hide().text('');
				}
			}, 'json');

		//}, 700);
	});

	$('#word_2').on('blur', function() {
		$('#desc2').val($('#word_2').val());

		//clearInterval(timer_word_2);
		//timer_word_2 = setTimeout(function() {
			var word2_q = { 'word2_q' : $('#word_2').val()};

			$.post('/chat/sign_up_page.php', word2_q, function(data){

				if (data.errors) {
					$('#word_2').css('border', '2px solid #C82923').addClass('error');
					$('#w_2_error').show().text('?');
					$('#w_2_err_exp').text(data.errors);
				}
				else {
					$('#word_2').css('border', '2px solid black').removeClass('error');
					$('#w_2_error').hide().text('');
					$('#w_2_err_exp').hide().text('');
				}
			}, 'json');

		//}, 1000);
	});

	$('#word_3').on('blur', function() {
		$('#desc3').val($('#word_3').val());
		//clearInterval(timer_word_3);
		//timer_word_3 = setTimeout(function() {
			var word3_q = { 'word3_q' : $('#word_3').val()};

			$.post('/chat/sign_up_page.php', word3_q, function(data){
				if (data.errors) {
					$('#word_3').css('border', '2px solid #C82923').addClass('error');
					$('#w_3_error').show().text('?');
					$('#w_3_err_exp').text(data.errors);
				}
				else {
					$('#word_3').css('border', '2px solid black').removeClass('error');
					$('#w_3_error').hide().text('');
					$('#w_3_err_exp').hide().text('');
				}
			}, 'json');

		//}, 1000);
	});


//SUBMIT---------------
//$('#next').click(function(event) {
	$('#sign_up_page_form').submit(function(event) {
		event.preventDefault();

		$('#next').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
			
			if ($('#city').is(':visible')) {
				var data = {
					'sign_up'      :  'sign_up',
					'gender'       :  $('#gender_select').val(),
					'country_id'   :  $('#country_id').val(),
					'city'         :  $('#city').val(),
					'word_1'       :  $('#word_1').val(),
					'word_2'       :  $('#word_2').val(),
					'word_3'       :  $('#word_3').val(),
				};
			}
			if ($('#zip').is(':visible')) {
				var data = {
					'sign_up'      :  'sign_up',
					'gender'       :  $('#gender_select').val(),
					'country_id'   :  $('#country_id').val(),
					'zip'          :  $('#zip').val(),
					'word_1'       :  $('#word_1').val(),
					'word_2'       :  $('#word_2').val(),
					'word_3'       :  $('#word_3').val(),
				};
			}


		$.ajax({
			type     : 'POST',
			url      : '/chat/sign_up_page.php', 
			data     : data, 
			dataType : 'json',
		})
		.done(function(data){
				if(data.errors) {	
					$('#next').html('').text('Done');
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
					if (data.errors.word1) {
						$('#word_1').css('border', '2px solid #C82923').addClass('error');
						$('#w_1_error').show().text('?');
						$('#w_1_err_exp').text(data.errors.word1);
					}
					if (data.errors.word2) {
						$('#word_2').css('border', '2px solid #C82923').addClass('error');
						$('#w_2_error').show().text('?');
						$('#w_2_err_exp').text(data.errors.word2);
					}
					if (data.errors.word3) {
						$('#word_3').css('border', '2px solid #C82923').addClass('error');
						$('#w_3_error').show().text('?');
						$('#w_3_err_exp').text(data.errors.word3);
					}
					if (data.errors.photo) {
						$('#p_error').show().text('?');
						$('#p_err_exp').text(data.errors.photo);
					}
				}
				if(data.success) {
					/*
					mixpanel.track('Gender and Location', {
						'gender'   : data.gender,
						'location' : data.loc,
						'state'    : data.state
					}, window.location.assign('/' + data.url));
					setTimeout(function(){ window.location.assign('/' + data.url); }, 500);
					*/
					//mixpanel.track('Words Photo', {}, window.location.assign('/' + data.url));
					//setTimeout(function(){ window.location.assign('/' + data.url); }, 500);
					window.location.assign('/' + data.url);			
				}
			});

});

});
