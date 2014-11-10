$(document).ready(function(){

	$('#fp_email').on('keyup', function(){
		$(this).css('border', '1px solid #1a1d2a');
	});

	$('#fp_submit').click(function(){
             				$('#sending').show();
							$('#sending').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');
					});

	$('#forgot_password_form').submit(function(event){

		var data = {
				'fp_email'	: $('#fp_email').val()
		};

		$.ajax({
			type      : 'POST',
            url       : 'chat/forgot_password.php',
            data      :  data,
            dataType  : 'json',	
		})
		.done(function(data){
			console.log(data);
			//alert(data);
			if (data.success) {
				$('#sending').html(data.message);
				$('.pop_landing').fadeOut(1800);
			}
			if (data.errors) {
				$('#sending').html(data.errors.message);
				$('#fp_email').css('border', '1px solid #C82923');
			}
		})
		.fail(function(data){
			console.log(data);
			 $('#sending').html('Sorry! There was an error, please try again');
		});

		event.preventDefault();
	});


});