$(document).ready(function(){

	$('#send_report').click(function(event){

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
				$('#close_report').show();
			}
			if (data.errors) {
				$('#report_sent').html('<p>' + data.message + '</p>');
				$('#close_report').show();
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
			$('#close_report').show();

			/*$('.pop_report').fadeOut(2300, function(){
				$('#report_sent').hide();
				$('.report_send').show();
				$('.report_cancel').show();
				$('.report_text').show();
			});*/
		});
		event.preventDefault();
	});

});