<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {
  
  log_this_action (profile_action_profile(), viewed_basic_action());
  echo '<div id="profile_page" class="my_page">';
    echo '<div class="header">';
      //echo 'Profile';
      flare_title('Profile');
    echo '</div>';
    
    echo '<div id="profile_photo_and_info">';
      show_my_main_photo();
      show_my_general_info();
    echo '</div>';
  
    echo '<div id="profile_photo_grid">';
        show_my_photo_grid($link=0);
      echo '</div>';
 
    show_my_descriptors_info(); 
    echo '<div style="width:100%; border-top:1px solid black; position:relative; top:32px">';
      show_my_interests_info();
    echo '</div>';
  echo '</div>';
  
   
}
?> 
