<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

if (isset($_POST["submit"])) {
  log_this_action (profile_action_interests(), editted_basic_action());
  update_my_interests ($_POST["activities"], $_POST["music"], $_POST["books"], $_POST["film_television"],
                          $_POST["spiritual"], $_POST["political"], $_POST["inspirational_figures"]);
  if ($_POST["submit"] == "Save and Go To the Next Step") {
    //update_my_profile_step ("nav4");
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav6&the_page=psel');
  }
  else {
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
  }
}
else {

  header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
}

?> 
