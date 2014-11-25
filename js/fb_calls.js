$(document).ready(function(){

//GENERAL CALLS ---------------------------------

 //FIND FRIENDS -------------------------------------------

	$('#sfb_friends').click(function(){
		$('#s_results').html('<div id="ajax_loader"><img src="/js/ajax_loader_sign_up.gif" /></div>');

    function statusChangeCallbackNTS(response) {
      console.log('statusChangeCallback');
      console.log(response);
      // The response object is returned with a status field that lets the
      // app know the current login status of the person.
      // Full docs on the response object can be found in the documentation
      // for FB.getLoginStatus().
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
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
          //alert(data.fb_ids.length);
          console.log('fb_ids: ');
          console.log(data.fb_ids);
          //var x = 0;
          for (i = 0; i < data.fb_ids.length; i++) {
            //console.log('data.fb_friends' + i + ': ');
            //console.log(data.fb_friends[i]);
        
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
                      $('#ajax_loader').remove();
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
                      //id = response['data'][0].id;
                      //fb_f.push('hello');
                      //$('#s_results').append(data.fb_friends[i]);
                      //fb_f.push(data.fb_friends[i]);
                      //fb_f.push(response['data'][0].id);
                    }
                  }
              }
            );
            //x++;
          }        
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        //document.getElementById('status').innerHTML = 'Please log ' +
        //  'into this app.';
        fbLoginMain();
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //document.getElementById('status').innerHTML = 'Please log ' +
        // 'into Facebook.';
      }
    }

		});
	});


});