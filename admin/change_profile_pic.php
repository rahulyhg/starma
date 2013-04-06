<?php
require_once ("../header.php");

  
if (isAdmin()) {

if (isset($_GET["photo_id"]) and isset($_SESSION["proxy_user_id"])) {
  $user_id = $_SESSION["proxy_user_id"];
  //echo valid_photo($_GET["photo_id"], get_my_user_id());
  //die();
  if (valid_photo($_GET["photo_id"], $user_id)) {
    change_profile_pic($_GET["photo_id"], $user_id);
    //log_this_action (profile_action_photos(), editted_basic_action());
  }
  do_redirect ( get_domain() . '/admin/edit_profile.php?user_id=' . $user_id);
  
   
}
else {
   do_redirect ( get_domain() . '/admin/edit_profile.php?user_id=' . $user_id);
}

}
?> 
