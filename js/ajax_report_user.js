$(document).ready(function(){

	$('#report_user').submit(function(event){

		var data = {
			'my_user_id'     :  $('input[name=my_user_id]').val(),
			'other_user_id'  :  $('input[name=other_user_id]').val()
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
			if(data) {
				$('#report_sent').html('<p>' + data + '</p>');
			}
			if (data) {
				$('#report_sent').html('<p>' + data + '</p>');
			}
				$('.pop_report').fadeOut(1900, function(){
					$('#report_sent').hide();
					$('.report_send').show();
					$('.report_cancel').show();
					$('.report_text').show();
				
			});
		})
		.fail(function(data){
			$('#report_sent').html('<p>There was an error sending the report.  Please try again later or contact Starma directly.</p>')
			$('.pop_report').fadeOut(2300, function(){
				$('#report_sent').hide();
				$('.report_send').show();
				$('.report_cancel').show();
				$('.report_text').show();
			});
		});
		event.preventDefault();
	});

});