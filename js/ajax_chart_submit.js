$(document).ready(function(){


	$('.chart_li').click(function(){

		if ($(this).children().children('.pass_poi_id').val() !== 1) {
			$('#chart_prev').show();
			$('#chart_next').show();
		}
		if ($(this).children().children('.pass_poi_id').val() == 1) {
			$('#chart_prev').hide();
			$('#chart_next').show();
		}
		if ($(this).children().children('.pass_poi_id').val() == 9) {
			$('#chart_next').hide();
		}

		//$('#planet_info').html().fadeOut('fast');
		$('#blurb').children().fadeOut(300);

		if($(this).hasClass('rahuketu')) {
			var poi_id = {
				'poi_id'     :   $(this).children().children('.pass_poi_id').val(),
				'chart_id'   :   $('input[name=chart_id]').val(),
				'sign_id1'   :   $(this).children().children('input[name=sign_id1]').val(),
				'sign_id2'   :   $(this).children().children('input[name=sign_id2]').val()
				};
		}
		else {
			var poi_id = {
				'poi_id'     :   $(this).children().children('.pass_poi_id').val(),
				'chart_id'   :   $('input[name=chart_id]').val(),
				'sign_id'    :   $(this).children().children('input[name=sign_id]').val()
				};
		}
			
			$.ajax({
				type: 'POST',
				url: 'chat/chart_submit.php',
				data: poi_id,
				dataType: 'json',

			})

			.done(function(data) {
				//alert('poi_id: ' + data.poi_id + ' - chart_id: ' + data.chart_id 
				//	+ ' - sign_id: ' + data.sign_id + ' - poi_info: ' + data.poi_info + ' - blurb: ' + data.blurb);
				if(!data["poi_in_sign2"]) {
					$('#blurb').html('<div id="planet_info">' + data.poi_info + '</div><span>' + data.poi_in_sign + data.blurb + '</span>').fadeIn(800);
				}
				else{
					$('#blurb').html('<div id="planet_info">' + data.poi_info + '</div><span>' + data.poi_in_sign + data.poi_in_sign2 + data.blurb + '</span>').fadeIn(800);
				}
			});

			$('li.chart_li').removeClass('selected');
			$(this).addClass('selected');
			$('.arrow').removeClass('arrow_left_on arrow_right_on');
			if($(this).children().children('.icon').hasClass('left')) {
				$(this).children().children('.arrow').addClass('arrow_left_on');
			}
			else {
				$(this).children().children('.arrow').addClass('arrow_right_on');
			}
		
		//event.preventDefault();
	});


	//PREV AND NEXT FOR CHART

	$('#chart_prev').click(function(){
		$('li').removeClass('prev');
		if ($('li.selected').children().children('.pass_poi_id').val() !== 5) {
			var prev = $('li.selected').prev('li');
			alert(prev.children().children('.pass_poi_id').val());
		}
		if ($('li.selected').children().children('.pass_poi_id').val() == 5) {
			var prev = $('div.left_side>ul>li:eq(4)');
			alert(prev.children().children('.pass_poi_id').val());
		}
		$(prev).addClass('prev');
		//alert($('li.selected').prev('li').children().children('.pass_poi_id').val());
		/*
		if (prev.children().children('.pass_poi_id').val() !== 1) {
			$('#chart_prev').show();
			$('#chart_next').show();
		}
		if (prev.children().children('.pass_poi_id').val() == 1) {
			$('#chart_prev').hide();
			$('#chart_next').show();
		}
		if (prev.children().children('.pass_poi_id').val() == 9) {
			$('#chart_next').hide();
		}

		//$('#planet_info').html().fadeOut('fast');
		$('#blurb').children().fadeOut(300);
		
		if($(this).hasClass('rahuketu')) {
			var poi_id = {
				'poi_id'     :   $('li.selected').prev('li').children().children('.pass_poi_id').val(),
				'chart_id'   :   $('input[name=chart_id]').val(),
				'sign_id1'   :   $('li.selected').prev('li').children().children('input[name=sign_id1]').val(),
				'sign_id2'   :   $('li.selected').prev('li').children().children('input[name=sign_id2]').val()
				};
		}
		else {
			var poi_id = {
				'poi_id'     :   prev.children().children('.pass_poi_id').val(),
				'chart_id'   :   $('input[name=chart_id]').val(),
				'sign_id'    :   prev.children().children('input[name=sign_id]').val()
				};
		}
			
			$.ajax({
				type: 'POST',
				url: 'chat/chart_submit.php',
				data: poi_id,
				dataType: 'json',

			})

			.done(function(data) {
				//alert('poi_id: ' + data.poi_id + ' - chart_id: ' + data.chart_id 
				//	+ ' - sign_id: ' + data.sign_id + ' - poi_info: ' + data.poi_info + ' - blurb: ' + data.blurb);
				if(!data["poi_in_sign2"]) {
					$('#blurb').html('<div id="planet_info">' + data.poi_info + '</div><span>' + data.poi_in_sign + data.blurb + '</span>').fadeIn(800);
				}
				else{
					$('#blurb').html('<div id="planet_info">' + data.poi_info + '</div><span>' + data.poi_in_sign + data.poi_in_sign2 + data.blurb + '</span>').fadeIn(800);
				}
			});

			$('li.chart_li').removeClass('selected');
			$('.prev').addClass('selected');
			$('.arrow').removeClass('arrow_left_on arrow_right_on');
			if($('.prev').children().children('.icon').hasClass('left')) {
				$('.prev').children().children('.arrow').addClass('arrow_left_on');
			}
			else {
				$('.prev').children().children('.arrow').addClass('arrow_right_on');
			}
		*/
	});

	$('#chart_next').click(function(){
		//alert($('li.selected').next('li').children().children('.pass_poi_id').val());
	});



});