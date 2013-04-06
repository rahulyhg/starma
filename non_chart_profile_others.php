<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

  if (valid_chart_view($_GET["chart_id2"])) {
    log_this_action (profile_action_profile(), viewed_basic_action(), $_GET["chart_id2"]);
    echo '<div id="profile_page">';
      echo '<div class="header">';
      //echo 'Profile';
        flare_title('Profile');
      echo '</div>';

      echo '<div id="profile_photo_and_info">';
        show_main_photo($_GET["chart_id2"]);
        show_general_info($_GET["chart_id2"]);
      echo '</div>';
      
      echo '<div id="profile_photo_grid">';
        show_photo_grid(get_user_id_from_chart_id ($_GET["chart_id2"]));
      echo '</div>';
 
      show_descriptors_info($_GET["chart_id2"]); 
 
      echo '<div class="profile_button chart_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&tier=4&chart_id2=' . $_GET["chart_id2"] . '"></a></div>';
      echo '<div class="profile_button compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '"></a></div>';     
      //echo '<div class="profile_button chat_button"><a href="#" onclick="chat_monitor.nowChatting(' . get_user_id_from_chart_id ($_GET["chart_id2"]) . ', 1); var chat_window = window.open(\'chat/chat_window.php?receiver_id=' . get_user_id_from_chart_id ($_GET["chart_id2"]) . '\',\'starma_chat_' . get_user_id_from_chart_id ($_GET["chart_id2"]) . '\',\'height=560px,width=540px\');chat_window.focus();"></a></div>';
      if (!isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"]))) {
        echo '<div class="profile_button chat_button"><a href="#" onclick="chat_all.openFullChat(' . get_user_id_from_chart_id ($_GET["chart_id2"]) . ',\'' . get_nickname (get_user_id_from_chart_id ($_GET["chart_id2"])) . '\',2)"></a></div>';
      }
      echo '<div class="profile_button ';
      if (is_my_favorite(get_user_id_from_chart_id ($_GET["chart_id2"]))) {
        echo 'remove_favorite_button';
        $toggle = 0;
      }
      else {
        echo 'add_favorite_button';
        $toggle = 1;
      }
      echo '"><a href="toggle_favorite.php?favorite=' . $toggle . '&favorite_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">Toggle Favorite</a></div>';
           
      echo '<div style="position:relative; bottom:88px;width:100%; border-top:1px solid black;">';
        show_interests_info($_GET["chart_id2"]);
      echo '</div>';      
    echo '</div>';
    
  }
  else {
    echo "You are not authorized to view this profile.";
  }
  
   
}
?> 

<div id="img_preloader">

  

  <img src="/img/Starma-Profile-View-Compatibility.png"/>
  <img src="/img/Starma-Profile-View-CompatibilityON.png"/>
  <img src="/img/Starma-Astrology-View-Chart.png"/>
  <img src="/img/Starma-Astrology-View-ChartON.png"/>


</div>
