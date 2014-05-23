<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

  log_this_action (profile_action_photos(), viewed_basic_action(), $_GET["chart_id2"]);
  
echo '<div id="photos">';

  echo '<div id="profile_photo_grid">';
        show_photo_grid(get_user_id_from_chart_id ($_GET["chart_id2"]));
  echo '</div>'; 

echo '</div>'; //close photos
    
}

?> 
