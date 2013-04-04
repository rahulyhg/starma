<?php
require_once ("header.php");

  
login_check_point($type="full", $domain=$domain);

if (isset($_POST["submit"])) {
  
  if ($_POST["submit"] == "Save and Go To the Next Step") {
    //update_my_profile_step ("nav4");
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav5&the_page=psel');
  }
  else {
    header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
  }
}
else {

  header( 'Location: https://www.' . $domain . '/main.php?the_left=nav1&the_page=psel');
}

?> 
