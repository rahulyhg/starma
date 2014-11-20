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
/*
  function sendID() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id' : response.id};

            $.ajax({
              type      : 'POST',
              url       : '/chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              //alert(data.check);
              //console.log(data.fb_id);
            });
      });
  }

  function assignID() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id' : response.id};

            $.ajax({
              type      : 'POST',
              url       : '/chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              //alert(data.check);
              //console.log(data.fb_id);
              userExistFB();
            });
      });
  }

  function userExistFB() {
    var data = {'exist' : 'exist'};

    $.ajax({
      type: 'POST',
      url: '/chat/fb_data.php',
      data: data,
      dataType: 'json'
    })
    .done(function(data){
      //console.log(data.user);
      if (data.errors) {
        if (data.errors.user_id) {
          console.log(data.errors.user_id);
        }
        if (data.errors.exists) {
          $('#sign_up_box').hide();
          $('#create_account_fb').show();
          console.log(data.errors.exists);
        }
      }
      if (data.success) {
        window.location.reload(true);
      }
    });
  }
*/
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


//SIGN UP AND LOGIN LANDING------------------------------------------
/*
  function fbSignUp () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        sendID();
        $('#sign_up_box').hide();
        $('#create_account_fb').show();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        setTimeout(checkLoginState(), 1000);
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        setTimeout(checkLoginState(), 1000);
      }
    }, {scope: 'public_profile,email,user_friends'});
  }
  function fbLogin () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        assignID();
        //userExistFB();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        //setTimeout(fbLogin(), 1000);
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //setTimeout(fbLogin(), 1000);
      }
    }, {scope: 'public_profile,email,user_friends'});
  }



//GUEST SIGN UP LOGIN--------------------------------------

function sendIDGuest() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id' : response.id};

            $.ajax({
              type      : 'POST',
              url       : '/chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              //alert(data.check);
              //console.log(data.fb_id);
            });
      });
  }

  function assignIDGuest() {
    FB.api('/me', function(response) {
        //console.log('Successful login for: ' + response.name);
        //document.getElementById('status').innerHTML =
        //  'Thanks for logging in, ' + response.name + '!';
        var data = {'fb_id' : response.id};

            $.ajax({
              type      : 'POST',
              url       : '/chat/fb_data.php',
              data      : data,
              dataType  : 'json'
            })
            .done(function(data){
              //alert(data.check);
              //console.log(data.fb_id);
              userExistFBGuest();
            });
      });
  }

  function userExistFBGuest() {
    var data = {'exist' : 'exist'};

    $.ajax({
      type: 'POST',
      url: '/chat/fb_data.php',
      data: data,
      dataType: 'json'
    })
    .done(function(data){
      //console.log(data.user);
      if (data.errors) {
        if (data.errors.user_id) {
          console.log(data.errors.user_id);
        }
        if (data.errors.exists) {
          $('#fb_or_email_login_guest').hide();
          $('#create_account_fb').show();
          console.log(data.errors.exists);
        }
      }
      if (data.success) {
        window.location.reload(true);
      }
    });
  }

	function fbSignUpGuest () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        sendIDGuest();
        $('#fb_or_email_guest').hide();
        $('#create_account_fb').show();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        setTimeout(checkLoginState(), 1000);
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        setTimeout(checkLoginState(), 1000);
      }
    }, {scope: 'public_profile,email,user_friends'});
  }
  function fbLoginGuest () {
    FB.login(function(response) {
    checkLoginState();
      // handle the response'
      if (response.status === 'connected') {
        // Logged into your app and Facebook.
        assignIDGuest();
        //userExistFB();
      } 
      else if (response.status === 'not_authorized') {
        // The person is logged into Facebook, but not your app.
        //setTimeout(fbLogin(), 1000);
      } 
      else {
        // The person is not logged into Facebook, so we're not sure if
        // they are logged into this app or not.
        //setTimeout(fbLogin(), 1000);
      }
    }, {scope: 'public_profile,email,user_friends'});
  }
*/


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