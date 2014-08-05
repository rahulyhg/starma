$(document).ready(function(){

	//var $invite = $('#msg_sendie').val();
	jQuery.fn.slideFadeToggle = function(easing, callback) {
    	return this.animate({ opacity: 'toggle', height: 'toggle' }, "fast", easing, callback);
	};

	$('.pop_landing_login').click(function(){
		$('.pop_login').slideFadeToggle();
	});

	$('.pop_landing_click').click(function(event){
		event.preventDefault();
		$('.pop_guest').slideFadeToggle();
		return false;
	});

	$('.pop_reg').click(function(){
		$('.pop_guest').slideFadeToggle(function() {
			$('#sign_up_box').show();
			$('#create_account').hide();
		});
	});

	$('.pop_log').click(function(){
		$('.pop_login').slideFadeToggle();
	});

	$('.pop_landing').click(function(){
		$('#create_account').hide();
		$('#landing_sign_up_box').show();
		$('.pop_landing').hide();
	});

	$('button[name=cancel]').click(function(){
		$('.pop_landing').slideFadeToggle(function() {
			$('#landing_sign_up_box').show();
			$('#create_account').hide();
		});
	});


	$('button[name=sign_up_email]').click(function(){
		$('#landing_sign_up_box').hide();
		$('#create_account').show();
		$('.pop_landing').show();
	});

});