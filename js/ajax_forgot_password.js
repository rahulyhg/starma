$(document).ready(function(){

	$('#fp_submit').click(function(){
             				$('#sending').show();
							$('#sending').html('<div id="ajax_loader"><img src="/js/ajax_loader.gif" /></div>');
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
			}
			if (data.errors) {
				$('#sending').html(data.errors.message);
			}
		})
		.fail(function(data){
			console.log(data);
			 $('#sending').html('Sorry! There was an error, please try again');
		});

		event.preventDefault();
	});


});