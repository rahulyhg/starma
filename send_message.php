<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

//echo '*' . $_POST["submit"] . '*';
//die();

if (isset($_POST["submit"])) {
  //log_this_action (profile_action_biography(), editted_basic_action());
  $other_user_id = $_POST["other_user_id"];
  insert_msg_line (get_my_user_id(), $other_user_id, date("Y-m-d H:i:s"), $_POST["text_body"], 1, 0, $is_message=1);
  do_redirect( $url = get_domain() . '/main.php?the_left=nav1&the_page=isel&other_user_id=' . $other_user_id); 
}
else {

   do_redirect( $url = get_domain() . '/main.php?the_left=nav1&the_page=isel');
}

?> 
