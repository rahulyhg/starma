$(document).ready(function(){

	$('#report_user').submit(function(event){

		var data = {
			'my_user_id'     :  $('input[name=my_user_id]').val(),
			'other_user_id'  :  $('input[name=other_user_id]').val()
		};

		

		event.preventDefault;
	});

});