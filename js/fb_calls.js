$(document).ready(function(){

//GENERAL CALLS ---------------------------------

 //FIND FRIENDS -------------------------------------------

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
      //var t = [];
			//alert(data.fb_ids.length);
      console.log('fb_ids: ');
      console.log(data.fb_ids);
      //var done = 0;
      var x = 0;
			for (i = 0; i < data.fb_ids.length; i++) {
        //console.log('data.fb_friends' + i + ': ');
				//console.log(data.fb_friends[i]);
        //fb_f.push(data.fb_friends[i]);
        //console.log('fb_f' + i + ': ');
        //console.log(fb_f);
        //done = 0;
				FB.api(
    				'/me/friends/' + data.fb_ids[i].fb_id,
    				function (response) {
              console.log('full response: ');
              console.log(response);
      					if (response != '' && !response.error) {
      						console.log('response: ');
      						console.log(response);
      						if (response['data'].length > 0) {
      							console.log('response id: '); 
      							console.log(response['data'][0].id);
      							//console.log('response name: '); 
      							//console.log(response['data'][0].name);
                    var send_id = {'fb_f_loop_id' : response['data'][0].id};
                    $.ajax({
                      type: 'POST',
                      url: '/chat/fb_data.php',
                      data: send_id,
                      dataType: 'json',
                    })
                    .done(function(r){
                      $('#s_results').append(r.fb_friend);
                    });
                    //var id = {}
                    //id = response['data'][0].id;
                    //fb_f.push('hello');
                    //$('#s_results').append(data.fb_friends[i]);
                    //fb_f.push(data.fb_friends[i]);
      							//fb_f.push(response['data'][0].id);
                    //fb_f[x] = response['data'][0].id.toString();
      							//console.log('name: ' + response.name + ', id: ' + response.id);
        						//t.push("2352");
      						}
      					}
                //done = 1;
    				}
				);
        x++;
        /*
        if(x == data.fb_ids.length) {
          console.log('x: ' + x);
          console.log('fb_id: ' + data.fb_ids[i]);
          console.log('fb_f:');
          console.log(fb_f);
          $('#s_results').append(fb_f);
        }
        */
			}
      
      
      //console.log('t: ');
      //console.log(t);
			//console.log('fb_f:');
			//console.log(fb_f);
      //console.log(fb_f.length);
      //console.log(JSON.stringify(fb_f));
			//var fb_f_ids = {'fb_f_ids' : t};
      //console.log('fb_f_ids');
      //console.log(fb_f_ids);
      
      /*
			$.ajax({
				type : 'POST',
				url : '/chat/fb_data.php',
				data : fb_f_ids,
				dataType : 'json'
			})
			.done(function(data){
				console.log('fb_f return: ');
				console.log(data.fb_f_ids);
        console.log('test: ' + data.test);
			});
    */
			//$('#s_results').html(data);
		});
	});


});