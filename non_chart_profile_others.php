<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

  if (valid_chart_view($_GET["chart_id2"])) {
    $section = grab_var('section','chart_selected');
    $western_there = grab_var('western_there',chart_already_there("Alternate",get_user_id_from_chart_id($_GET["chart_id2"])) );
    $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"])));

    $chart_selected = '';
    $photos_selected = '';
    $about_selected = '';
    $western_selected = '';
  
    $$section = 'selected';

    log_this_action (profile_action_profile(), viewed_basic_action(), $_GET["chart_id2"], get_user_id_from_chart_id($_GET["chart_id2"]));
    echo '<div id="profile_page"';
      if ($isCeleb) { 
        echo ' class="celeb_page"';
      }
    echo '>';
      //echo '<div class="header">';
      //echo 'Profile';
      //  flare_title('Profile');
      //echo '</div>';

      echo '<div id="profile_photo_and_info">';
        show_main_photo($_GET["chart_id2"]);
        show_general_info($_GET["chart_id2"]);
      echo '</div>';
      
      //echo '<div id="profile_photo_grid">';
      //  show_photo_grid(get_user_id_from_chart_id ($_GET["chart_id2"]));
      //echo '</div>';
 
      if (!$isCeleb) {
        show_descriptors_info($_GET["chart_id2"]); 
      }

      echo '<div id="profile_sections"/>';
        echo '<div id="profile_nav">
          <ul>
            <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=chart_selected">Birth Chart</a></li>';
            if (!$isCeleb)  {
              echo '<li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=photos_selected">Photos</a></li>';
            }
            echo '<li';
            if (!$western_there) {
              echo ' class="end"';
            } 
            echo '><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=about_selected">About</a></li>';
            if ($western_there)  {        
              echo '<li class="end"><a class="' . $western_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=1&tier=3&section=western_selected">Western View</a></li>';
            }
          echo '</ul>
        </div>';
        echo '<div id="section"/>';
          if ($section == 'chart_selected') {
            require('chart_others.php');
          }
          elseif (($section == 'photos_selected') && (!$isCeleb)) {
            require('photos_others.php');
          }
          elseif ($section == 'about_selected') {
            echo '<div style="position:relative; top:75px;width:100%;">';
              show_interests_info($_GET["chart_id2"]);
            echo '</div>';   
          }
          elseif ($section == 'western_selected') {
            require('chart_others.php');
          }
        echo '</div>';
      echo '</div>';
 
      echo '<div class="profile_button compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '">Compare</a></div>';     

      if (!$isCeleb) {
        echo '<div class="profile_button chat_button"><a href="#" onclick="chat_all.openFullChat(' . get_user_id_from_chart_id ($_GET["chart_id2"]) . ',\'' . get_nickname (get_user_id_from_chart_id ($_GET["chart_id2"])) . '\',2)">Chat</a></div>';
      }
  
      echo '<div class="profile_button message_button"><a href="?the_page=isel&the_left=nav1&other_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">Message</a></div>';     

      echo '<div class="profile_button ';
      if (is_my_favorite(get_user_id_from_chart_id ($_GET["chart_id2"]))) {
        echo 'remove_favorite_button';
        $toggle = 0;
        $button_text = "Remove From Favorites";
      }
      else {
        echo 'add_favorite_button';
        $toggle = 1;
        $button_text = "Add to Favorites";
      }
      echo '"><a href="toggle_favorite.php?favorite=' . $toggle . '&favorite_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">' . $button_text . '</a></div>';
           
         
    echo '</div>';
    
  }
  else {
    echo "You are not authorized to view this profile.";
  }
  
   
}
?> 

<div id="img_preloader">

  

  <img src="/img/profile/Starma-Astrology-Compare.png"/>
  <img src="/img/profile/Starma-Astrology-CompareON.png"/>
  <img src="/img/profile/Starma-Astrology-Message.png"/>
  <img src="/img/profile/Starma-Astrology-MessageON.png"/>
  <img src="/img/profile/Starma-Astrology-Chat.png"/>
  <img src="/img/profile/Starma-Astrology-ChatON.png"/>

  <img src="/img/profile/Starma-Astrology-Favorites.png"/>
  <img src="/img/profile/Starma-Astrology-FavoritesON.png"/>

</div>
