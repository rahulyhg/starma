<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

if (isset($_POST["submit"])) {
  log_this_action (profile_action_interests(), editted_basic_action());
  update_my_interests ($_POST["about_me"], $_POST["activities"], $_POST["music"], $_POST["books"], $_POST["film_television"],
                          $_POST["spiritual"], $_POST["political"], $_POST["inspirational_figures"]);
  if ($_POST["submit"] == "Save and Go To the Next Step") {
    //update_my_profile_step ("nav4");
    do_redirect ( get_domain() . '/main.php?the_page=psel&the_left=nav1&western=0&section=about_selected');
  }
  else {
    do_redirect ( get_domain() . '/main.php?the_page=psel&the_left=nav1&western=0&section=about_selected');
  }
}
else {

  do_redirect ( get_domain() . '/main.php?the_page=psel&the_left=nav1&western=0&section=about_selected');
}

?> 
