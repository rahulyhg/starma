<?php
require_once ("../header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
$user_id = $_POST["user_id"];
$error=0;

  if($_FILES['image']['name'] && num_photos($user_id) < max_photos()) {
	list($file,$error) = upload('image','../img/user/','jpeg,gif,png,jpg');
	if($error) print $error;
        if (!associate_photo_with_user($file, $user_id)) {
          $error = 1; 
          //LOG THE UPLOAD, BUT INDICATE THAT IT COULDNT BE ASSOCIATED
          //log_this_action (profile_action_photos(), uploaded_basic_action(), -5);
        }
        
  }
  else {
    if (!$_FILES['image']['name']) {
      $error = 3;
    }
    else {
      $error = 2;
    }
  }
  if ($error == 0) {
    //log_this_action (profile_action_photos(), uploaded_basic_action());
       do_redirect ( get_domain() . '/admin/edit_profile.php?user_id=' . $user_id);
  }
  else {
    do_redirect ( get_domain() . '/admin/edit_profile.php?user_id=' . $user_id . '&error=' . $error);
  }

}
?> 
