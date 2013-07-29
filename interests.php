<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  log_this_action (profile_action_interests(), viewed_basic_action());
//if (isset($_GET["edit"])) {
//  $edit = $_GET["edit"];/
//}
//elseif (!is_my_profile_done()) {
//  $edit = 1;
//}
//else {
//  $edit = 0; 
//}

  //if ($edit == 0) {
  //  show_general_info();
  //}
  //else {
    //echo '<div style="position:relative; top:3px">';
    //  flare_title ("Edit Interests");
    //echo '</div>';
    edit_interests_info();
  //}
}

?> 
