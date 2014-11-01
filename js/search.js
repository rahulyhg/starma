$(document).ready(function() {
	/*
	$('#gender_select').on('change', function() {
		$('#gender_select').css('border-color', 'black');
	});

	$('#s_vars_submit').click(function(event){
		if($('#gender_select').val() == 'none') {
			event.preventDefault();
			$('#gender_select').css('border-color', '#C82923');
		}
	});

	*/
	//alert($('#s_results').scrollTop());
	var load_next = $('#load_next').val();

	$(window).scroll(function() {
		var H = $(window).height();
		var top = $(window).scrollTop();
		var all = document.body.clientHeight;
		//console.log('height: ' + H);
		//console.log('scrollTop: ' + top);
		//console.log('all: ' + all);
		if (H + top == all && load_next == 'true') {
			$('#s_loading').show();
			var data = { 'page'  		:  $('#next_page').val(),
						 'limit' 		:  24,
						 'low_bound'	:  $('#low_bound').val(),
						 'high_bound'	:  $('#high_bound').val(),
						 'gender' 		:  $('#gender').val(),
						}; 

			$.ajax({
				type      : 'POST',
				url       : '/chat/scroll.php',
				data      : data,
				dataType  : 'json'
			})
			.done(function(data){
				if (data.errors) {
					alert('error');
				}
				if (data.new_users) {
					$('#s_results').append(data.new_users);
					//alert(data.new_users);
					//console.log('page: ' + data.page + 'begin: ' + data.begin + 'limit: ' + data.limit);
					$('#s_loading').hide();
				}
			});
		}
		//if (height => $('.user_block').scrollTop())
	});
	//if ($('.next_page').length()) {
		//$('#s_results').scroll(function() {
		//	if ($(window).scrollTop() + $(window).height() > )

		//	alert($('.next_page').val());
		//});
	//}
	
});