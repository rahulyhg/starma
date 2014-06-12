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
    $$tab = 'not_selected';

    //*************---Matt adding msg popup from Message button
    
    $chart_id1 = $_GET["chart_id1"];
    $chart_id2 = $_GET["chart_id2"];
    $other_user_id = get_user_id_from_chart_id ($chart_id2);

    //*************---endMatt stuff

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
    echo '<div id="profile_top_bar">';
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

       //TEST FOR ADDING text_type to compare_button
      echo '<div class="profile_button compare_button">
            <span class="compare_button_title">Compare</span>
              <select id="compare_select" onchange="location = this.options[this.selectedIndex].value;">
                <option value="">Compatiblity Test</option>
                <option value="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romance</option>
                <option value="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Friends</option>
              </select>
            </div>';

      if (!$isCeleb) {
        echo '<div class="profile_button chat_button"><a href="#" onclick="chat_all.openFullChat(' . get_user_id_from_chart_id ($_GET["chart_id2"]) . ',\'' . get_nickname (get_user_id_from_chart_id ($_GET["chart_id2"])) . '\',2)">Chat</a></div>';

        //************---Matt adding jquery popup from Message button
        echo '<div class="profile_button message_button"><a href="#" id="msg_pop">Message</a></div>';
        echo '<div id="msg_sheen" class="pop">';
    
          echo '<div id="msg_sheen_screen" class="pop">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content" class="pop">';
                echo '<div id="msg_type_area">';
                  echo '<form id="send-message-area" action="send_msg_from_profile.php" method="POST">
                          <label for="msg_sendie" id="msg_label">New Message</label>
                          <textarea id="msg_sendie" name="text_body" maxlength = "500" ></textarea>
                          <input type="submit" name="submit" value="Send" class="msg_send"/>
                          <button type="button" name="cancel" class="msg_cancel">Cancel</button>
                          <input type="hidden" value=' . $other_user_id . ' name="other_user_id"/>
                          <input type="hidden" value=' . $chart_id1 . ' name="chart_id1"/>
                          <input type="hidden" value=' . $chart_id2 . ' name="chart_id2"/>                         
                        </form>';
                      echo '<span id="msg_sent"></span>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
        //***********---endMatt Stuff

        //echo '<div class="profile_button message_button"><a href="?the_page=isel&the_left=nav1&other_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">Message</a></div>';     
      }
  
      

      echo '<div id="add_to_favorites" class="profile_button ';
      if ($isCeleb) {
        echo 'celeb_favorites ';
      }
      if (is_my_favorite(get_user_id_from_chart_id ($_GET["chart_id2"]))) {
        echo 'remove_favorite_button';
        //$toggle = 0;
        $button_text = "Remove From Favorites";
      }
      else {
        echo 'add_favorite_button';
        //$toggle = 1;
        $button_text = "Add to Favorites";
      }
      
      echo '"><span>' . $button_text . '</span>';
      //echo '<input type="hidden" value=' . $toggle . ' name="toggle"/></div>';
      //echo 'href="toggle_favorite.php?favorite=' . $toggle . '&favorite_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">' . $button_text . '</a></div>';
           
         
    echo '</div>';
    
  }
  else {
    echo "You are not authorized to view this profile.";
  }

  echo '</div>';  //close profile_top_bar
  if($isCeleb) {
    echo '<div style="clear:both;"></div>';
  }
      echo '<div id="profile_nav">
          <ul>
            <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=chart_selected">Birth Chart</a></li>';
            echo '<li><a class="' . $houses_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=houses_selected">House Lords</a></li>';
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

      echo '<div id="profile_sections">';
      
        echo '<div id="section">';
          if ($section == 'chart_selected') {
            require('chart_others.php');
          }
          elseif ($section == 'houses_selected') {
            //require('houses_others.php');
            echo '<div style="height:300px;">Coming Soon...</div>';
          }
          elseif (($section == 'photos_selected') && (!$isCeleb)) {
            require('photos_others.php');
          }
          elseif ($section == 'about_selected') {
            //echo '<div style="position:relative; top:75px;width:100%;">';
              show_interests_info($_GET["chart_id2"]);
            //echo '</div>';   
          }
          elseif ($section == 'western_selected') {
            require('chart_others.php');
          }
        echo '</div>';
      echo '</div>';
 
      //echo '<div class="profile_button compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Compare</a></div>';     

     
  
   echo "<script type='text/javascript' src='js/msg_popup.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_msg_send_from_popup.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_chart_submit.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_add_favs.js'></script>";

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
