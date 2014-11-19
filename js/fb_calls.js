$(document).ready(function(){

	$('#sfb_friends').click(function(){
		$('#s_results').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');

		var data = {'fb_friends' : true};

		$.ajax({
			type : 'POST',
			url : '/chat/fb_data.php',
			data : data,
			dataType : 'json'
		})
		.done(function(data){
			console.log('data: ');
			console.log(data);
			var fb_f = [];
			//alert(data.fb_friends.length);
			for (i = 0; i < data.fb_friends.length; i++) {
				//alert(data.fb_friends[i]);
				FB.api(
    				'/me/friends/' + data.fb_friends[i],
    				function (response) {
      					if (response != '' && !response.error) {
      						//console.log('response: ');
      						//console.log(response);
      						if (response['data'].length > 0) {
      							//console.log('response id: '); 
      							//console.log(response['data'][0].id);
      							//console.log('response name: '); 
      							//console.log(response['data'][0].name);
      							fb_f.push(response['data'][0].id);
      							//console.log('name: ' + response.name + ', id: ' + response.id);
        						/* handle the result */
      						}
      					}
    				}
				);
			}
			console.log('fb_f:');
			console.log(fb_f);

			var fb_f_ids = {'fb_f' : fb_f};
			$.ajax({
				type : 'POST',
				url : '/chat/fb_data.php',
				data : fb_f_ids,
				dataType : 'json'
			})
			.done(function(data){
				console.log('fb_f return: ');
				console.log(data);
			});
			//$('#s_results').html(data);
		});
	});


});