<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  log_this_action (profile_action_three_words(), viewed_basic_action());
  edit_descriptors_info();
}

?> 
