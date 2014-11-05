$(document).ready(function() {

	$('#ue_search').keypress(function(e) {
		if (e.which == 13) {
			$('#ues_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
			$('#single_u').html('');
			var s_val = $('#ue_search').val();
			alert(s_val);
			if (!s_val == '') {
				if (s_val.search(/@/) == -1) {
					//alert('username');
					var data = {'username' : s_val};
				}
				if (s_val.search(/@/) != -1) {
					//alert('email');
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
					$('#s_results').hide();
					if (data.errors) {
						if (data.errors.username) {
							//alert(data.errors.username);
							$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.username + '</div>');
						}
						if (data.errors.email) {
							//alert(data.errors.email);
							$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.email + '</div>');
						}
						if (data.errors.user) {
							//alert(data.errors.user);
							$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.user + '</div>');
						}
					}
					if(data.user) {
						//alert(data.user_id + ', ' + data.chart_id);
						$('#single_u').show().append(data.user);
					}		
				});
			}
		}
	});

	$('#ues_button').on('click', function(){
		$('#ues_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
		//$('#single_u>.user_block').remove();
		$('#single_u').html('');
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
					$('#s_results').hide();
					if (data.errors) {
						if (data.errors.username) {
							//alert(data.errors.username);
							$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.username + '</div>');
						}
						if (data.errors.email) {
							//alert(data.errors.email);
							$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.email + '</div>');
						}
						if (data.errors.user) {
							//alert(data.errors.user);
							$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.user + '</div>');
						}
					}
					if(data.user) {
						//alert(data.user);
						$('#single_u').show().append(data.user);
					}		
				});
			}
		//}
		
	});
});