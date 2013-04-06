<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

if (isset($_GET["photo_id"])) {
  if (isset($_SESSION["proxy_user_id"]) and isAdmin()) {
    $user_id = $_SESSION["proxy_user_id"];
  }
  else {
    $user_id = get_my_user_id();
  }
  //echo valid_photo($_GET["photo_id"], get_my_user_id());
  //die();
  $error=0;
  if (valid_photo($_GET["photo_id"], $user_id)) {
    if (delete_photo ($_GET["photo_id"], $user_id)) {
      log_this_action (profile_action_photos(), deleted_basic_action(), $user_id);
    }
    else {
      $error=1;
    }
  }
  if ($user_id == get_my_user_id()) {
    do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel&error=' . $error);
  }
  else {
    do_redirect ( get_domain() . '/admin/edit_profile.php?user_id=' . $user_id . '&error=' . $error);
  }
  
   
}
else {
  do_redirect ( get_domain() . '/' . get_landing() );
}

}
?> 

