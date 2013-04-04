<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

if (isset($_POST["submit"])) {
  update_my_profile_info ($_POST["first_name"], $_POST["last_name"], $_POST["gender"], $_POST["location"]);
  log_this_action (profile_action_general(), editted_basic_action());
  if ($_POST["submit"] == "Save and Go To the Next Step") {
    //update_my_profile_step ("nav3");
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav3&the_page=psel');
  }
  else {
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
  }
}
else {

  header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
}

?> 
