$(document).ready(function(){

	$('#sort_by_sign').on('change', function(){
		var data = {'sign_id'		   : $('#sort_by_sign').val(),
					'sort_by_sign' : 'sort_by_sign'
					};

		$.ajax({
			type: 'POST',
			url: '/chat/sort_users.php',
			data: data,
			dataType: 'json'
		})
		.done(function(data){
			$('#s_results').hide();
			$('#hide_s').show();
			$('#users_found').show();
			if (data.errors) {
				$('#s_results').show();
				$('#hide_s').hide();
				$('#users_found').hide();
				alert('Something went wrong! Please refresh and try again');
			}
			if (data.users_found) {
				/*if (data.next_page) {
					if(data.next_page == 3) {
						$('#js_back_to_top').fadeTo(200,0); 
						$('#js_back_to_top').show();
					}
					$('#next_page').val(data.next_page);
				}
				if (data.end) {
					$('#next_page').remove();
					$('#load_next').val('false');
				}
				if (!data.end) {
					$('#load_next').val('true');
				}
				*/
				$('#users_found').append(data.users_found);
				//console.log('page: ' + data.page + 'begin: ' + data.begin + 'limit: ' + data.limit);
				$('#s_loading').hide();
			}
		});
	});

});