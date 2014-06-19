$(document).ready(function(){

	$('#report_user').submit(function(event){

		var data = {
			'my_user_id'           :  $('input[name=my_user_id]').val(),
			'other_user_id'        :  $('input[name=other_user_id]').val(),
			'additional_comments'  :  $('#additional_comments').val()
		};

		$.ajax ({
			type      : 'POST',
            url       : 'chat/report_user.php',
            data      :  data,
            dataType  : 'json',
		})
		.done(function(data){
			console.log(data);
			//alert(data);
			if(data.success) {
				$('#report_sent').html('<p>' + data.message + '</p>');
				$('.report_close').show();
			}
			if (data.errors) {
				$('#report_sent').html('<p>' + data + '</p>');
				$('#report_close').show();
			}
			/*
				$('.pop_report').fadeOut(1900, function(){
					$('#report_sent').hide();
					$('.report_send').show();
					$('.report_cancel').show();
					$('.report_text').show();
				
			});
			*/
		})
		.fail(function(data){
			$('#report_sent').html('<p>There was an error sending the report.  Please try again later or contact Starma directly.</p>')
			$('#report_close').show();
<<<<<<< HEAD
			/*$('.pop_report').fadeOut(3000, function(){
=======
			/*$('.pop_report').fadeOut(2300, function(){
>>>>>>> Version-2.0-updates
				$('#report_sent').hide();
				$('.report_send').show();
				$('.report_cancel').show();
				$('.report_text').show();
			});*/
		});
		event.preventDefault();
	});

});