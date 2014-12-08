$(document).ready(function(){

//CHART TUTORIAL ---

	$('#view_chart_tutorial').click(function(){
		$('#view_chart_tutorial>div').html('<img src="/js/ajax_loader_sign_up.gif" />');
		var view_compare_tutorial = {'view_chart_tutorial' : 'view_chart_tutorial'};

		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  view_chart_tutorial,
			dataType 	: 'json',
		})
		.done(function(data){
			if (data.errors) {
				console.log(data.errors);
			}
			if (data.success) {
				window.location.reload(true);
			}
		});
	});

	if ($('.chart_pop').length) {
		$('.chart_pop').show();
	}
	/*
	$('#ct1_done').click(function(){
		$('.chart_pop').slideFadeToggle();
	});
	*/

	$('#clickMe').click(function(event){
		if($('#cfc').prop('checked')) {
			var data = {'cfc' : 1};
		}
		if(!$('#cfc').prop('checked')) {
			var data = {'cfc' : 0};
		}

			$.ajax({
				type      : 'POST',
				url       : '/chat/pop_tuts.php',
				data      : data,
				dataType  : 'json',
			})
			.done(function(data){
				if (data.errors) {
					if (data.errors.set) {
						$('.cfv_err').text(data.errors.set);
					}
				}
				if (data.success) {
					//alert(data.cfv);
					$('#cfv').text(data.cfv);
				}
			}); 
	});



//CHART POP TUTS------------------------------

	$('#ct1_done').click(function(){
		$('#msg_sheen_ct1').fadeOut(300);
		$('#msg_sheen_ct2').fadeIn(300);
		$('#western_circle').fadeIn(300);
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.45);
	});

	$('#ct2_done').click(function(){
		$('#msg_sheen_ct2').fadeOut(300);
		$('#western_circle').fadeOut(300);
		$('#msg_sheen_ct3').fadeIn(300);
		$('#why_vedic_circle').fadeIn(300);
	});

	$('#ct3_done').click(function(){
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.71);
		$('#msg_sheen_ct3').fadeOut(300);
		$('#why_vedic_circle').fadeOut(300);
		$('#msg_sheen_ct4').fadeIn(300);
	});

	$('#ct4_done').click(function(){
		$('#msg_sheen_ct4').fadeOut(300);
		$('#msg_sheen_ct5').fadeIn(300);
		$('#poi_circle_left, #poi_circle_right').fadeIn(300);
	});

	$('#ct5_done').click(function(){
		$('#msg_sheen_ct5').fadeOut(300);
		$('#poi_circle_left, #poi_circle_right').fadeOut(300);
		$('.chart_pop').fadeOut(300);

		var data = {'chart_flag' : 0};
		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  data,
			dataType 	: 'json',
		})
		.done(function(data){
			if (data.errors) {
				console.log(data.errors.chart_flag);
			}
			if (data.chart_flag) {
				console.log(data.chart_flag);
			}
		});
	});


//COMPARE POPTUTS -------------------------------------------

	$('#view_compare_tutorial').click(function(){
		$('#view_compare_tutorial>div').html('<img src="/js/ajax_loader_sign_up.gif" />');
		if ($('#major_select').hasClass('selected')) {
			var view_compare_tutorial = {'view_major_compare_tutorial' : 'view_major_compare_tutorial'};
		}
		else if ($('#minor_select').hasClass('selected')) {
			var view_compare_tutorial = {'view_minor_compare_tutorial' : 'view_minor_compare_tutorial'};
		}
		else {
			var view_compare_tutorial = {'view_compare_tutorial' : 'view_compare_tutorial'};
		}

		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  view_compare_tutorial,
			dataType 	: 'json',
		})
		.done(function(data){
			var the_page = $('#the_page').val();
			var the_left = $('#the_left').val();
			var c_id1 = $('#c_id1').val();
			var c_id2 = $('#c_id2').val();
			if (data.errors) {
				console.log(data.errors);
			}
			if (data.success) {
				//console.log(data.success)
				window.location.reload(true);
			}
			if (data.major) {
				//console.log('/main.php?the_page=' + the_page + '&the_left=' + the_left + '&results_type=major&text_type=1&tier=2&stage=2&chart_id1='+ c_id1 + '&chart_id2=' + c_id2 + '&from_profile=true');
				window.location.assign('/main.php?the_page=' + the_page + '&the_left=' + the_left + '&results_type=major&text_type=1&tier=2&stage=2&chart_id1='+ c_id1 + '&chart_id2=' + c_id2 + '&from_profile=true');
			}
			if (data.minor) {
				//console.log('/main.php?the_page=' + the_page + '&the_left=' + the_left + '&results_type=minor&text_type=1&tier=2&stage=2&chart_id1='+ c_id1 + '&chart_id2=' + c_id2 + '&from_profile=true')
				window.location.assign('/main.php?the_page=' + the_page + '&the_left=' + the_left + '&results_type=minor&text_type=1&tier=2&stage=2&chart_id1='+ c_id1 + '&chart_id2=' + c_id2 + '&from_profile=true');
			}
		});
	});

//MAJOR ----

if ($('.major_compare_pop').length) {
		$('.major_compare_pop').show();
	}
	
	$('#mact1_done').click(function(){
		$('#msg_sheen_mact1').fadeOut(300);
		$('#msg_sheen_mact2').fadeIn(300);
		
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.45);
	});

	$('#mact2_done').click(function(){
		$('#msg_sheen_mact2').fadeOut(300);
		//$('#western_circle').fadeOut(300);
		$('#major_text_circle').fadeIn(300);
		$('#msg_sheen_mact3').fadeIn(300);
		//$('#why_vedic_circle').fadeIn(300);
	});

	$('#mact3_done').click(function(){
		$('#msg_sheen_mact3').fadeOut(300);
		//$('#western_circle').fadeOut(300);
		$('#major_text_circle').fadeOut(300);
		$('#msg_sheen_mact4').fadeIn(300);
		$('#compare_subnav_circle').fadeIn(300);
	});

	$('#mact4_done').click(function(){
		//$('#msg_sheen_screen_ct').fadeTo('slow', 0.71);
		$('#msg_sheen_mact4').fadeOut(300);
		$('#compare_subnav_circle').fadeOut(300);
		$('.major_compare_pop').fadeOut(300);

		var data = {'major_compare_flag' : 0};
		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  data,
			dataType 	: 'json',
		})
		.done(function(data){
			if (data.errors) {
				console.log(data.errors);
			}
			if (data.major_compare_flag) {
				$('#msg_sheen_screen_mact').addClass('tut_viewed');
				console.log(data.major_compare_flag);
			}
		});
		
	});


//MINOR ----

	if($('#minor_select').hasClass('selected')) {	//FOR VIEW TUTORIAL RELOAD
		if ($('.minor_compare_pop').length) {
			$('.minor_compare_pop').show();
		}
	}

	$('#minor_select').click(function(){
		if ($('.minor_compare_pop').length && !$('#msg_sheen_screen_mict').hasClass('tut_viewed')) {
			$('.minor_compare_pop').show();
		}
	});

	$('#mict1_done').click(function(){
		$('#msg_sheen_mict1').fadeOut(300);
		$('#msg_sheen_mict2').fadeIn(300);
		$('#supporting_tabs_circle').fadeIn(300);
	});

	$('#mict2_done').click(function(){
		$('#msg_sheen_mict2').fadeOut(300);
		$('#supporting_tabs_circle').fadeOut(300);
		$('#msg_sheen_mict3').fadeIn(300);
		$('#supporting_sum_up_circle').fadeIn(300);
	});

	$('#mict3_done').click(function(){
		$('#msg_sheen_mict3').fadeOut(300);
		$('#supporting_sum_up_circle').fadeOut(300);
		$('#pillar_icons_circle').fadeIn(300);
		$('#msg_sheen_mict4').fadeIn(300);
		//$('#why_vedic_circle').fadeIn(300);
	});

	$('#mict4_done').click(function(){
		$('#msg_sheen_mict4').fadeOut(300);
		$('#pillar_icons_circle').fadeOut(300);	
		$('.minor_compare_pop').fadeOut(300);	

		var data = {'minor_compare_flag' : 0};
		$.ajax({
			type 		:  'POST',
			url 		:  '/chat/pop_tuts.php',
			data 		:  data,
			dataType 	: 'json',
		})
		.done(function(data){
			if (data.errors) {
				console.log(data.errors);
			}
			if (data.minor_compare_flag) {
				$('#msg_sheen_screen_mict').addClass('tut_viewed');
				console.log(data.minor_compare_flag);
			}
		});
	});

});