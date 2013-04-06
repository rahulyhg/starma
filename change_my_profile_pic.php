<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

if (isset($_GET["photo_id"])) {
  //echo valid_photo($_GET["photo_id"], get_my_user_id());
  //die();
  if (valid_photo($_GET["photo_id"], get_my_user_id())) {
    change_my_profile_pic($_GET["photo_id"]);
    log_this_action (profile_action_photos(), editted_basic_action());
  }
  do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel');
  
   
}
else {
  do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel');
}

}
?> 
