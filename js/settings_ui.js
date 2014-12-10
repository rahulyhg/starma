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

		//$('#pref_fb').prop('disabled', true);

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
					window.location.reload(true);
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

//EMAIL SEARCH PRIVACY-----

	$('#escb').click(function(){
		$('#es_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#escb').prop('checked')) {
			var data = { 'escb' : 1 };
		}
		if(!$('#escb').prop('checked')) {
			var data = { 'escb' : 0 };
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
				if (data.errors.invalid_hlcb) {
					$('#es_done').show().html(data.errors.invalid);
				}
				if (data.errors.set_hlcb) {
					$('#es_done').show().html(data.errors.set);
                           
				}
                     $('#escb').prop('checked', false);
			}
			if (data.msg) {
				$('#es_done').show().html(data.msg).fadeOut(1200);
			}
		});

	});


//HOUSE LORDS-----

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
				if (data.errors.invalid_hlcb) {
					$('#hl_done').show().html(data.errors.invalid);
				}
				if (data.errors.set_hlcb) {
					$('#hl_done').show().html(data.errors.set);
                           
				}
                     $('#hlcb').prop('checked', false);
			}
			if (data.msg) {
				$('#hl_done').show().html(data.msg).fadeOut(1200);
			}
		});

	});



//CHART PRIVACY -----

    $('#chartcb').click(function(){
    	if($('#chartcb').prop('checked')) {
    		$('.chartcb_confirm_box').show();
    		$('#chartcb_confirm_text').addClass('private').removeClass('public').text('By choosing to keep your birth chart private you will still appear under the "New to Starma" page, and your personal Birth Chart, House Lords, and Astrologers View will be invisible to other users.  However, other users\' Birth Charts, House Lords and Astrologers View will be invisible to you.  Because of this you won\'t be able to test your compatibility with other users and they won\'t be able to test their compatibility with you.  Ar you sure you want to choose this option?');
    	}
    	else {
    		$('.chartcb_confirm_box').show();
    		$('#chartcb_confirm_text').addClass('public').removeClass('private').text('Make my Birth Chart public so I can see other people\'s Birth Charts and test our compatibility!');
    	}
    });

    $('#chartcb_confirm').click(function(){ 
    	$('.chartcb_confirm_box').fadeOut(300);
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
                //$('#hlcb').prop('checked', false);
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
				if (data.errors.invalid_chartcb) {
					$('#chart_done').show().html(data.errors.invalid);
				}
				if (data.errors.set_chartcb) {
					$('#chart_done').show().html(data.errors.set);
                           
				}
				if (data.errors.invalid_hlcb) {
					$('#hl_done').show().html(data.errors.invalid);
				}
				if (data.errors.set_hlcb) {
					$('#hl_done').show().html(data.errors.set);
                           
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
	
	$('#chartcb_cancel').click(function(){
		if ($('#chartcb_confirm_text').hasClass('private')) {
			$('#chartcb').prop('checked', false);
		}	
		if ($('#chartcb_confirm_text').hasClass('public')) {
			$('#chartcb').prop('checked', true);
		}
		$('.chartcb_confirm_box').fadeOut(300);
	});

//CHAT EMAILS-----

	$('#cecb').click(function(){
		$('#ce_done').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		if($('#cecb').prop('checked')) {
			var data = { 'cecb' : 1 };
		}
		if(!$('#cecb').prop('checked')) {
			var data = { 'cecb' : 0 };
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
				if (data.errors.invalid_cecb) {
					$('#ce_done').show().html(data.errors.invalid);
				}
				if (data.errors.set_hlcb) {
					$('#ce_done').show().html(data.errors.set);
                           
				}
                     $('#cecb').prop('checked', false);
			}
			if (data.msg) {
				$('#ce_done').show().html(data.msg).fadeOut(1200);
			}
		});

	});


//CHANGE USERNAME ----------------
	
	/*
	$('#u_err').mouseenter(function(){
		$('#u_err_exp').show();
	});
	$('#u_err').mouseleave(function(){
		$('#u_err_exp').hide();
	});
	*/

	$('#change_username').click(function(){
		$('.change_username_box').show();
	});

	$('#username').on('keyup', function(){
		$(this).css('border', '2px solid black');
	});

	$('#username_cancel').click(function(){
		$('.change_username_box').fadeOut(300);
		$('#username').val('');
	});

	$('#username').on('keypress', function(e){
		if (e.which == 13) {
			$('#u_err').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
			var username = {'username' : $('#username').val()};

			$.ajax({
				type: 'POST',
				url: 'chat/ajax_privacy.php',
				data: username,
				dataType: 'json',
			})
			.done(function(data){
				if (data.errors) {
					$('#u_err_exp').text(data.message);
					$('#username').css('border', '2px solid #C82923');
					//$('#u_err').show().text('?');
				}
				if (data.success) {
					window.location.reload(true);
				}
			});
		}
	});

	$('#username_confirm').click(function(){
		$('#u_err').show().html('<img src="/js/ajax_loader_sign_up.gif" />');
		var username = {'username' : $('#username').val()};

		$.ajax({
			type: 'POST',
			url: 'chat/ajax_privacy.php',
			data: username,
			dataType: 'json',
		})
		.done(function(data){
			if (data.errors) {
				$('#u_err_exp').text(data.message);
				$('#username').css('border', '2px solid #C82923');
				//$('#u_err').show().text('?');
			}
			if (data.success) {
				window.location.reload(true);
			}
		});
	});


//FB CONNECTED --------------------------------------
	
	$('#pref_fb').click(function(){
		if ($('#create_pass').length) {
			//if ($('#pref_fb').prop('disabled', true)) {
			$('#create_pass_first').show().text('Before you disconnect from Facebook you must create a password so you can login to Starma without using your Facebook account');
			//}
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