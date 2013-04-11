<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  
  if (!isset($_GET["other_user_id"])) {
    $other_user_id = 0;
  }
  else {
    $other_user_id = $_GET["other_user_id"];
  }
  echo '<div style="padding-top:3px; padding-bottom:10px;">';
  flare_title ("Inbox");
  echo '</div>';
  echo '<div id="inbox_user_list">';
      echo '<div id="inbox_header">';
        echo 'Converstations';
      echo '</div>';
      $user_msg_history = get_my_msgs();
      $user_list = extract_users_from_msgs_list($user_msg_history);
      echo '<div id="list_body" onmouseover="this.style.overflowY=\'auto\'" onmouseout="this.style.overflowY=\'hidden\'">';
      echo '<ul>';
      foreach ($user_list as $user_id => $num_new_msgs) {
        if (profile_info($user_id)) {
          echo '<li>';
            echo '<div class="new_ball_space';
            if ($num_new_msgs > 0) {
              echo ' new';
            }
            echo '"></div>';
            echo '<div class="hover_box">';
              echo '<div class="grid_photo_border_wrapper"><div class="grid_photo">';
                show_user_inbox_picture ('?the_page=isel&the_left=nav1&other_user_id=' . $user_id, $user_id);
                if ($num_new_msgs > 0) {
                  if ($num_new_msgs == 1) {
                    echo '<span>' . $num_new_msgs . ' new message!</span>';
                  }
                  else {
                    echo '<span>' . $num_new_msgs . ' new messages!</span>';
                  }
                }
              echo '</div></div>';
            echo '</div>';
          echo '</li>';  
        }
      }
      echo '</ul>';
      echo '</div>';
  echo '</div>';
    
  
    
 
  echo '<div id="inbox_history">';
      echo '<div id="inbox_header">';
        echo 'History';
      echo '</div>';
      echo '<div id="inbox_chat_area">';
        if ($other_user_id == 0) {
          echo 'Compose Blank Goes Here';
        }
        else {
          show_msg_area_inbox ($other_user_id);
        }
      echo '</div>';
      
  echo '</div>';
    
  
  
}

  


?> 

<script type="text/javascript">
  $('.chat_area').scrollTop($('.chat_area')[0].scrollHeight);
</script>