$(document).ready(function(){

//GENERAL CALLS ---------------------------------

function revokeFB() {
      FB.api(
      'me/permissions',
      'DELETE',
      function (response) {
        if (response && !response.error) {
            console.log('delete');
            console.log(response);
          }
      });
  }

  function assignIDSettings() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id'         : response.id,
                    'reconnect_fb'  : 'reconnect_fb'
                  };

            $.ajax({
              type      : 'POST',
              url       : '/chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              if (data.errors) {
                if (data.errors.set) {
                  console.log(data.errors.set);
                }
              }
              if (data.success) {
                console.log(data.success);
              }
              //alert(data.check);
              //console.log(data.fb_id);
              //userExistFB();
            });
      });
    }


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
      var t = [];
			//alert(data.fb_friends.length);
      //var x = 0;
			for (i = 0; i < data.fb_friends.length; i++) {
        //console.log('data.fb_friends' + i + ': ');
				//console.log(data.fb_friends[i]);
        //fb_f.push(data.fb_friends[i]);
        //console.log('fb_f' + i + ': ');
        //console.log(fb_f);
        
				FB.api(
    				'/me/friends/' + data.fb_friends[i],
    				function (response) {
      					if (response != '' && !response.error) {
      						console.log('response: ');
      						console.log(response);
      						if (response['data'].length > 0) {
      							//console.log('response id: '); 
      							//console.log(response['data'][0].id);
      							//console.log('response name: '); 
      							//console.log(response['data'][0].name);
                    //var id = {}
                    //id = response['data'][0].id;
                    //fb_f.push('hello');
      							fb_f.push(response['data'][0].id);
                    //fb_f[x] = response['data'][0].id.toString();
      							//console.log('name: ' + response.name + ', id: ' + response.id);
        						t.push("2352");
                   // x++;
      						}
      					}
    				}
				);
      
			}
      
      
      console.log('t: ');
      console.log(t);
			console.log('fb_f:');
			console.log(fb_f);
      console.log(fb_f.length);
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