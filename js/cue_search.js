$(document).ready(function() {

	$('#hide_s').click(function(){
		$('#single_u').html('').hide();
		$('#s_results').show();
		$('#hide_s').hide();
	});


//CELEB USERNAME AND EMAIL FOR REGULAR USER SEARCH---------------------------------

	$('#cue_search').keypress(function(e) {
		if (e.which == 13) {
			var s_val = $('#cue_search').val();
			var from = $('#from').val();
			//alert(s_val);
			if (!s_val == '') {
				$('#cue_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
				$('#single_u').html('');
				if (s_val.search(/@/) == -1) {
					//alert('username');
					if (from == 'nts') {
						var data = {'username' : s_val};
					}
					if (from == 'celeb') {
						var data = {'celebname' : s_val};
					}
				}
				if (s_val.search(/@/) != -1) {
					//alert('email');
					var data = {'email' : s_val};
				}

				if (from == 'nts') {
					$.ajax ({
						type		: 'POST',
						url			: '/chat/cue_search.php',
						data		: data,
						dataType	: 'json',
					})
					.done(function(data){
						$('#cue_button').html('Go!');
						$('#s_results').hide();
						$('#hide_s').show();
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
				if (from == 'c') {
					$.ajax ({
						type		: 'POST',
						url			: '/chat/cue_search.php',
						data		: data,
						dataType	: 'json',
					})
					.done(function(data){
						$('#cue_button').html('Go!');
						$('#s_results').hide();
						if (data.errors) {
							if (data.errors.celebname) {
								//alert(data.errors.username);
								$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.celebname + '</div>');
							}
							if (data.errors.celeb) {
								//alert(data.errors.user);
								$('#single_u').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.user + '</div>');
							}
						}
						if(data.user) {
							//alert(data.user_id + ', ' + data.chart_id);
							$('#single_u').show().append(data.celeb);
						}		
					});
				}
				
			}
		}
	});

	$('#cue_button').on('click', function(){
			var s_val = $('#cue_search').val();
			var from = $('#from').val();
			if (!s_val == '') {
				$('#cue_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
				$('#single_u').html('');
				if (s_val.search(/@/) == -1) {
					//alert('username');
					if (from == 'nts') {
						var data = {'username' : s_val};
					}
					if (from == 'celeb') {
						var data = {'celebname' : s_val};
					}
				}
				if (s_val.search(/@/) != -1) {
					//alert('email');
					var data = {'email' : s_val};
				}

				$.ajax ({
					type		: 'POST',
					url			: '/chat/cue_search.php',
					data		: data,
					dataType	: 'json',
				})
				.done(function(data){
					$('#cue_button').html('Go!');
					$('#s_results').hide();
					$('#hide_s').show();
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