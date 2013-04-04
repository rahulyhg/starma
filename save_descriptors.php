<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

if (isset($_POST["submit"])) {
  log_this_action (profile_action_three_words(), editted_basic_action());
  update_descriptors (array($_POST["des_name_1"], $_POST["des_name_2"], $_POST["des_name_3"]));
  if ($_POST["submit"] == "Save and Go To the Next Step") {
    //update_my_profile_step ("nav4");
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav4&the_page=psel');
  }
  else {
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
  }
}
else {

  header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
}

?> 
