$(document).ready(function() {

	$('#hide_s').click(function(){
		$('#users_found').html('').hide();
		$('#s_results').show();
		$('#hide_s').hide();
	});

	$('#cue_search').keyup(function(e){
		var s_length = $(this).val().length;
		if (e.which != 13) {
			if (s_length > 2) {
				$('#cue_button').text('Go!').css('color', 'black');
			}
		}
	});


//CELEB USERNAME AND EMAIL FOR REGULAR USER SEARCH---------------------------------

	$('#cue_search').keypress(function(e) {
		if (e.which == 13) {
			var s_length = $(this).val().length;
			var s_val = $('#cue_search').val();
			var from = $('#from').val();
			//alert(s_val);
			if (!s_val == '') {
				if (s_length > 2) {
					//alert(s_val);
					$('#cue_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
					$('#users_found').html('');

					if (from == 'nts') {		//FROM NEW TO STARMA------------
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
							url			: '/chat/cue_search.php',
							data		: data,
							dataType	: 'json',
						})
						.done(function(data){
							$('#cue_button').html('Go!');
							$('#s_results').hide();
							$('#hide_s').show();
							$('#users_found').show();
							if (data.errors) {
								if (data.errors.username) {
									//alert(data.errors.username);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.username + '</div>');
								}
								if (data.errors.email) {
									//alert(data.errors.email);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.email + '</div>');
								}
								if (data.errors.user) {
									//alert(data.errors.user);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.user + '</div>');
								}
							}
							if(data.users_found) {
								//alert(data.user_id + ', ' + data.chart_id);
								$('#users_found').show().append(data.users_found);
							}		
						});
					}
					if (from == 'celeb') {		//FROM CELEBRITIES--------------
						var data = {'celebname' : s_val};

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
							$('#users_found').show();
							if (data.errors) {
								if (data.errors.celebname) {
									//alert(data.errors.username);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.celebname + '</div>');
								}
								if (data.errors.celeb) {
									//alert(data.errors.user);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.celeb + '</div>');
								}
							}
							if(data.users_found) {
								//alert(data.user_id + ', ' + data.chart_id);
								$('#users_found').show().append(data.users_found);
							}		
						});
					}
				}
				if (s_length < 3) {
					//alert(s_length);
					$('#cue_button').text('Must be at least 3 characters').css('color', '#c82923');
				}
			}
				
		}
	});

	$('#cue_button').on('click', function(){
			var s_length = $('#cue_search').val().length;
			var s_val = $('#cue_search').val();
			var from = $('#from').val();
			//alert(s_val);
			if (!s_val == '') {
				if (s_length > 2) {
					//alert(s_val);
					$('#cue_button').html('<img src="/js/ajax_loader_sign_up.gif" />');
					$('#users_found').html('');

					if (from == 'nts') {		//FROM NEW TO STARMA------------
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
							url			: '/chat/cue_search.php',
							data		: data,
							dataType	: 'json',
						})
						.done(function(data){
							$('#cue_button').html('Go!');
							$('#s_results').hide();
							$('#hide_s').show();
							$('#users_found').show();
							if (data.errors) {
								if (data.errors.username) {
									//alert(data.errors.username);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.username + '</div>');
								}
								if (data.errors.email) {
									//alert(data.errors.email);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.email + '</div>');
								}
								if (data.errors.user) {
									//alert(data.errors.user);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.user + '</div>');
								}
							}
							if(data.users_found) {
								//alert(data.user_id + ', ' + data.chart_id);
								$('#users_found').show().append(data.users_found);
							}		
						});
					}
					if (from == 'celeb') {		//FROM CELEBRITIES--------------
						var data = {'celebname' : s_val};

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
							$('#users_found').show();
							if (data.errors) {
								if (data.errors.celebname) {
									//alert(data.errors.username);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.celebname + '</div>');
								}
								if (data.errors.celeb) {
									//alert(data.errors.user);
									$('#users_found').html('<div id="s_err" class="later_on" style="font-size:1.4em;">' + data.errors.celeb + '</div>');
								}
							}
							if(data.users_found) {
								//alert(data.user_id + ', ' + data.chart_id);
								$('#users_found').show().append(data.users_found);
							}		
						});
					}
				}
				if (s_length < 3) {
					//alert(s_length);
					$('#cue_button').text('Must be at least 3 characters').css('color', '#c82923');
				}
			}
		
		});
});