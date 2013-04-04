<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

if (isset($_GET["photo_id"])) {
  //echo valid_photo($_GET["photo_id"], get_my_user_id());
  //die();
  $error=0;
  if (valid_photo($_GET["photo_id"], get_my_user_id())) {
    if (delete_photo ($_GET["photo_id"], get_my_user_id())) {
      log_this_action (profile_action_photos(), deleted_basic_action());
    }
    else {
      $error=1;
    }
  }
  header( 'Location: https://www.' . $domain . '/main.php?the_left=nav4&the_page=psel&error=' . $error);
  
   
}
else {
  header( 'Location: https://www.' . $domain . '/main.php?the_left=nav4&the_page=psel');
}

}
?> 
