<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

log_this_action (profile_action_general(), viewed_basic_action());

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
    edit_general_info();
  //}
}

?> 
