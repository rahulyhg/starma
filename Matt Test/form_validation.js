$(document).ready(function () {
  var validateUsername = $('#username_error');
  $('#nickname').keyup(function () {
    var t = this; 
    var nickname = t.value;
    if (this.value != this.lastValue) {
      if (this.timer) {
          clearTimeout(this.timer);
          validateUsername.removeClass('error').html('<img src="images/ajax-loader.gif" height="16" width="16" /> checking availability...');
      }

      this.timer = setTimeout(function () {
        $.ajax({
          url: 'register.php',
          data: nickname,
          dataType: 'json',
          type: 'POST',
          success: function (j) {
            validateUsername.html(j.msg);
          }
        });
      }, 200);
      
      this.lastValue = this.value;
    }
  });
});

/************************   Adjustments to be made to register.php

  Have an $errors[] and $data[], return $data['success'] or $data['failure']
  and need to json_encode() $data[] from validation script
  then 


*************************   Adjustments to Ajax form_validation.js

  success: function(data) {
  
    console.log(data);

    if(!data.success){  //returned json object from register.php
      
      if(data.errors.nickname) {
        $('#username_error').html(...);
      }

    }

    else{
      $output = registerNewUser($_POST['nickname'], $_POST['password'], $_POST['password'], $_POST['email'], $_POST['email2'], $_POST['year_birthday'], $_POST['month_birthday'], $_POST['day_birthday'], $agreement);
        if (sizeof($output) <= 1){

          log_this_action (account_action_user(), registered_basic_action(), -1, -1, -1, $output[0]);
          if ($user = basic_user_data($output[0])) {
            echo 'User ' . $user["user_id"] . 'is there.<br>';
          }
          else {
            echo 'Failed to obtain User profile<br>';
          }
          //echo '*' . $output[0] . '*<br>';
          //echo '*' . $user["user_id"] . '*<br>';
          //print_r ($user); 
          //die();
          loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id']);
          do_redirect( $url = get_domain() . '/' . get_landing());
    }

  }
}