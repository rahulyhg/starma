$(document).ready(function(){

	$('#sort_by_sign').on('change', function(){
		var data = {'sign_id'		   : $('#sort_by_sign').val(),
					'sort_by_sign' : 'sort_by_sign'
					};

		$.ajax({
			type: 'POST',
			url: '/chat/sort_users.php',
			data: data,
			dataType: 'json'
		})
		.done(function(data){
			
		});
	});

});