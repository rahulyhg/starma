$(document).ready(function(){

	$('#report_send').submit(function(event){

		var data = {
			'my_user_id'     :  $('input[name=my_user_id]').val(),
			'other_user_id'  :  $('input[name=other_user_id]').val()
		};

		$.ajax {
			type      : 'POST',
            url       : 'chat/report_user.php',
            data      :  data,
            dataType  : 'json',
		}
		.done(function(data){
			console.log(data);
			alert(data);
			$('.pop_report')fadeOut(1700, function(){
				$('report_send').show();
				$('report_cancel').show();
				$('.report_text').show();
			});
		});

		//event.preventDefault;
	});

});