$(document).ready(function() {

	
	$(window).scroll(function() {
		if ($('#s_results').is(':visible')) {
			var load_next = $('#load_next').val();
			var H = $(window).height();
			var top = $(window).scrollTop();
			var all = document.body.clientHeight;
			//console.log('height: ' + H);
			//console.log('scrollTop: ' + top);
			//console.log('all: ' + all);
			if (parseInt(H) + parseInt(top) > (parseInt(all) - 800) && load_next == 'true') {
				$('#load_next').val('false');
				$('#s_loading').show();
				if ($('#search').val() == 'true') {
					var data = { 
							 'page'  		:  $('#next_page').val(),
						 	 'limit' 		:  25,
						 	 'low_bound'	:  $('#low_bound').val(),
						 	 'high_bound'	:  $('#high_bound').val(),
						 	 'gender' 		:  $('#gender').val(),
						 	 'search'		:  $('#search').val(),
					}; 
				}
				if ($('#nts').val() == 'true') {
					var data = {
							 'page'  		:  $('#next_page').val(),
						 	 'limit' 		:  25, 
						 	 'nts'			:  $('#nts').val(),
						 	 'url'			:  $('#url').val(),
					};
				}

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
						if (data.next_page) {
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
						$('#s_results').append(data.new_users);
						//alert(data.new_users);
						//console.log('page: ' + data.page + 'begin: ' + data.begin + 'limit: ' + data.limit);
						$('#s_loading').hide();
					}
				});
			}
		}
		//if (height => $('.user_block').scrollTop())
	});
	
});