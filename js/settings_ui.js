$(document).ready(function(){

	

	//CHANGING PASSWORD----
	if ($('#change_pass').length) {

		$('input[name=change_pass]').prop('disabled', true);

		$('input[name=password2]').on('keyup', function() {
			var new_pass = $('input[name=password]').val();
			var new_pass2 = $('input[name=password2]').val();
			if(new_pass != "") {
				if(new_pass == new_pass2) {
					$('.pass_correct').show().fadeOut(1200);
					$('input[name=change_pass]').prop('disabled', false);
					//alert('correct!');
				}
				else {
					$('input[name=change_pass]').prop('disabled', true);
				}
			}
		});

		$('#change_pass').click(function(){
			$('#ajax_loader').html('<img src="/js/ajax_loader_sign_up.gif" />');
			var data_pass = {
				'oldpassword'  : $('input[name=oldpassword]').val(),
				'password'     : $('input[name=password]').val(),
				'password2'    : $('input[name=password2]').val()
				};

			$.ajax({
				type: 'POST',
				url: 'chat/ajax_change_password.php',
				data: data_pass,
				dataType: 'json',

				})

				.done(function(data) {
					//alert(data);
					if (data.success) {
						$('#ajax_loader').html('');
						$('#pass_validation').show().html('Your password has been updated!').css('color', 'green');
						//alert(data.pass);
					}
					if (data.errors) {
						$('#ajax_loader').html('');
						$('#pass_validation').css('color', 'red');
						if(data.errors.pass_length){	
							$('#pass_validation').show().text('*' + data.errors.pass_length);
						}
						if(data.errors.oldpass) {
							$('#pass_validation').show().text('*' + data.errors.oldpass);
						}
						if(data.errors.mismatch) {
							$('#pass_validation').show().text('*' + data.errors.mismatch);
						}
						if(data.errors.characters) {
							$('#pass_validation').show().text('*' + data.errors.characters);
						}
					}
					$('input[name=oldpassword]').val('');
					$('input[name=password]').val('');
					$('input[name=password2]').val('');
				});

				//event.preventDefault();
		});
	}



	
	//CREATING PASSWORD----

	if ($('#create_pass').length) {

		$('#pref_fb').prop('disabled', true);

		$('#create_pass').prop('disabled', true);

		$('input[name=password2]').on('keyup', function() {
			var new_pass = $('input[name=password]').val();
			var new_pass2 = $('input[name=password2]').val();
			if(new_pass != "") {
				if(new_pass == new_pass2) {
					$('.pass_correct').show().fadeOut(1200);
					$('#create_pass').prop('disabled', false);
					//alert('correct!');
				}
				else {
					$('#create_pass').prop('disabled', true);
				}
			}
		});


		$('#create_pass').click(function(){
			$('#ajax_loader').html('<img src="/js/ajax_loader_sign_up.gif" />');
			var data_pass = {
				'create_pass'  : 'create_pass',
				'password'     : $('input[name=password]').val(),
				'password2'    : $('input[name=password2]').val()
				};

			$.ajax({
				type: 'POST',
				url: 'chat/ajax_change_password.php',
				data: data_pass,
				dataType: 'json',

			})

			.done(function(data) {
					//alert(data);
				if (data.success) {
					$('#ajax_loader').html('');
					$('#pass_validation').show().html('Your password has been updated!').css('color', 'green');
						//alert(data.pass);
				}
				if (data.errors) {
					$('#ajax_loader').html('');
					$('#pass_validation').css('color', 'red');
					if(data.errors.pass_length){	
						$('#pass_validation').show().text('*' + data.errors.pass_length);
					}
					if(data.errors.oldpass) {
						$('#pass_validation').show().text('*' + data.errors.oldpass);
					}
					if(data.errors.mismatch) {
						$('#pass_validation').show().text('*' + data.errors.mismatch);
					}
					if(data.errors.characters) {
						$('#pass_validation').show().text('*' + data.errors.characters);
					}
				}
				$('input[name=password]').val('');
				$('input[name=password2]').val('');
			});

				//event.preventDefault();
		});
	}
	

//PRIVACY --------------------------------------

	$('#hlcb').click(function(){
		$('#hl_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#hlcb').prop('checked')) {
			var data = { 'hlcb' : 1 };
		}
		if(!$('#hlcb').prop('checked')) {
			var data = { 'hlcb' : 0 };
		}
		//alert(data);
		$.ajax({
				type: 'POST',
				url: 'chat/ajax_privacy.php',
				data: data,
				dataType: 'json',
		})
		.done(function(data){
			if (data.errors) {
				if (data.errors.invalid) {
					$('#hl_done').show().html(data.errors.invalid);
				}
				if (data.errors.set) {
					$('#hl_done').show().html(data.errors.set);
                           
				}
                     $('#hlcb').prop('checked', false);
			}
			if (data.msg) {
				$('#hl_done').show().html(data.msg).fadeOut(1200);
			}
		});

	});

     $('#chartcb').click(function(){
		$('#chart_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#chartcb').prop('checked')) {
			var data = { 'chartcb' : 1 };
                $('#hlcb').prop('checked', true);                      
                $('#hlcb').prop('disabled', true);
                $('#hl_text').css({'color':'gray'});         
                                            
           }
		if(!$('#chartcb').prop('checked')) {
			var data = { 'chartcb' : 0 };
                $('#hlcb').prop('disabled', false);
                $('#hl_text').css({'color':'black'});
		}
		//alert(data);
		$.ajax({
				type: 'POST',
				url: 'chat/ajax_privacy.php',
				data: data,
				dataType: 'json',
		})
		.done(function(data){
			if (data.errors) {
				if (data.errors.invalid) {
					$('#chart_done').show().html(data.errors.invalid);
				}
				if (data.errors.set) {
					$('#chart_done').show().html(data.errors.set);
                           
				}
                      $('#chartcb').prop('checked', false);
                      $('#hlcb').prop('disabled', false);
                      $('#hl_text').css({'color':'black'});
			}
               	if (data.msg) {
				$('#chart_done').show().html(data.msg).fadeOut(1200);
			}
		});

	});

//FB CONNECTED --------------------------------------
	
	/*
	$('#fbcb').click(function(){
		$('#fb_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#fbcb').prop('checked')) {
			//fbLoginSettings();
			var data = { 'fbcb' : 1 };
		}
		if(!$('#fbcb').prop('checked')) {
			//revokeFB();
			var data = { 'fbcb' : 0 };
		}
		//alert(data);
		$.ajax({
				type: 'POST',
				url: 'chat/ajax_privacy.php',
				data: data,
				dataType: 'json',
		})
		.done(function(data){
			if (data.errors) {
				if (data.errors.invalid) {
					$('#fb_done').show().html(data.errors.invalid);
				}
				if (data.errors.set) {
					$('#fb_done').show().html(data.errors.set);
				}
			}
			if (data.success) {
				$('#fb_done').show().html(data.msg).fadeOut(1200);
				if (data.unset) {
					revokeFBSettings();
				}
				if (data.set) {
					fbLoginMain();
				}
			}
		});

	});
	*/
	$('#pref_fb').click(function(){
		if ($('#pref_fb').prop('disabled', true)) {
			$('#create_pass_first').show().text('Before you disconnect from Facebook you must create a password so you can login to Starma without using your Facebook account');
		}
		else {
			$('#pref_fb').prop('disabled', true);
			$('#fb_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
			if ($('#pref_fb').hasClass('connect_fb')) {
				fbLoginMain();
			}
			if($('#pref_fb').hasClass('disconnect_fb')) {
				revokeFBSettings();
			}
		}
	});



//TUTORIALS --------------------------------------
	
	//CHART TUTORIAL--------------------

	$('#cfcb').click(function() {
		$('#cf_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#cfcb').prop('checked')) {
			var data = {'cfcb' : 1};
		}
		if(!$('#cfcb').prop('checked')) {
			var data = {'cfcb' : 0};
		}

		$.ajax({
			type: 'POST',
			url: '/chat/ajax_settings_tuts.php',
			data: data,
			dataType: 'json',
		})
		.done(function(data) {
			if (data.errors) {
				if(data.errors.invalid) {
					$('#cf_done').show().html(data.errors.invalid);
				}
				if (data.errors.set) {
					$('#cf_done').show().html(data.errors.set);
				}
			}
			if (data.msg) {
				$('#cf_done').show().html(data.msg).fadeOut(1200);
			}
		});
	});

	//COMPARE TUTORIAL----------------------

	$('#cofcb').click(function() {
		$('#cof_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#cofcb').prop('checked')) {
			var data = {'cofcb' : 1};
		}
		if(!$('#cofcb').prop('checked')) {
			var data = {'cofcb' : 0};
		}

		$.ajax({
			type: 'POST',
			url: '/chat/ajax_settings_tuts.php',
			data: data,
			dataType: 'json',
		})
		.done(function(data) {
			if (data.errors) {
				if(data.errors.invalid) {
					$('#cof_done').show().html(data.errors.invalid);
				}
				if (data.errors.major_set) {
					$('#cof_done').show().html(data.errors.major_set);
				}
				if (data.errors.minor_set) {
					$('#cof_done').show().html(data.errors.minor_set);
				}
			}
			if (data.msg) {
				$('#cof_done').show().html(data.msg).fadeOut(1200);
			}
		});
	});




});