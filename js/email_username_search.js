$(document).ready(function() {

	$('#ue_search').keypress(function(e) {
		if (e.which == 13) {
			$('#ues_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
			var s_val = $('#ue_search').val();
			alert(s_val);
			if (!s_val == '') {
				if (s_val.search(/@/) == -1) {
					alert('username');
					var data = {'username' : s_val};
				}
				if (s_val.search(/@/) != -1) {
					alert('email');
					var data = {'email' : s_val};
				}

				$.ajax ({
					type		: 'POST',
					url			: '/chat/ue_search.php',
					data		: data,
					dataType	: 'json',
				})
				.done(function(data){
					$('#ues_button').html('Search');
					if (data.errors) {
						if (data.errors.username) {
							alert(data.errors.username);
						}
						if (data.errors.email) {
							alert(data.errors.email);
						}
					}
					if(data.user) {
						//alert(data.user);
						$('#s_results').hide();
						$('#single_u').show().append(data.user);
					}		
				});
			}
		}
	});

	$('#ues_button').on('click', function(){
		$('#ues_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
			var s_val = $('#ue_search').val();
			alert(s_val);
			if (!s_val == '') {
				if (s_val.search(/@/) == -1) {
					alert('username');
					var data = {'username' : s_val};
				}
				if (s_val.search(/@/) != -1) {
					alert('email');
					var data = {'email' : s_val};
				}

				$.ajax ({
					type		: 'POST',
					url			: '/chat/ue_search.php',
					data		: data,
					dataType	: 'json',
				})
				.done(function(data){
					$('#ues_button').html('Search');
					if (data.errors) {
						if (data.errors.username) {
							alert(data.errors.username);
						}
						if (data.errors.email) {
							alert(data.errors.email);
						}
					}
					if(data.user) {
						//alert(data.user);
						$('#s_results').hide();
						$('#single_u').show().append(data.user);
					}		
				});
			}
		//}
		
	});
});