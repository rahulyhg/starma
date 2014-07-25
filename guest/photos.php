<?php
require_once ("header.php");

$guest_user_id = get_guest_user_id();
$guest_chart_id = get_guest_chart_id($guest_user_id);  
//if (login_check_point($type="full", $domain=$domain)) {

//log_this_action (profile_action_photos(), viewed_basic_action());
    
      echo '<div id="photos">';
      show_photo_grid($guest_user_id);
      /*
      if (isset($_GET["error"])) {
        echo '<div id="photo_error">';
          if ($_GET["error"] == 1) {
            echo "Error Deleting Photo.  Please contact Starma.com Administration.";
          }
          elseif ($_GET["error"] == 2) {
            echo "You have reached the " . max_photos() . " maximum allowed profile photos.";
          }
        echo '</div>';
      }
      */
    echo '</div>';  //close wrapper
    
//}

?> 
