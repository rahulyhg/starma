<?php
require_once ("header.php");

//**************GUEST VIEW********************//




//if (login_check_point($type="full")) {

  if (valid_chart_view($_GET["chart_id2"])) {
    $guest_user_id = get_guest_user_id();
    $guest_chart_id = get_guest_chart_id($guest_user_id);
    $western_there = grab_var('western_there',chart_already_there("Alternate",get_user_id_from_chart_id($_GET["chart_id2"])) );
    /*
    $section = grab_var('section','chart_selected');
    
    

    $chart_selected = '';
    $photos_selected = '';
    $about_selected = '';
    $western_selected = '';
  
    $$section = 'selected';
    $$tab = 'not_selected';
    */
    $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"])));
    //*************---Matt adding msg popup from Message button
    
    $chart_id1 = $_GET["chart_id1"];
    $chart_id2 = $_GET["chart_id2"];
    $other_user_id = get_user_id_from_chart_id ($chart_id2);

    //*************---endMatt stuff
    //LOGGING
    //log_this_action (profile_action_profile(), viewed_basic_action(), $_GET["chart_id2"], get_user_id_from_chart_id($_GET["chart_id2"]));
    echo '<div id="profile_page"';
      if ($isCeleb) { 
        echo ' class="celeb_page"';
      }
    echo '>';


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

    if($isCeleb) {
      echo '<div style="float:right; width:193px;">'; //CONTAINER FOR BUTTONS ON RIGHT
    }
       //TEST FOR ADDING text_type to compare_button
    echo '<div class="profile_button compare_button">';
      echo '<div style="position:relative; top:32px; left:5px; text-align:center;">
              <a href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Compare<span class="div_link"></span></a>
            </div>';
      /*
      echo '<div id="compare_menu">Compare';
        echo '<div class="dropdown">';
          echo '<ul>';
            echo '<li><a href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">As Friends</a></li>';
            echo '<li><a style="border-bottom:1px solid black;" href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romantically</a></li>';
          echo '</ul>';
        echo '</div>';
      echo '</div>';
      */
    echo '</div>';

      if (!$isCeleb) {
        echo '<div class="profile_button chat_button"><a href="#" class="pop_guest_click">Chat</a></div>';
        
        //************---Matt adding jquery popup from Message button
        echo '<div class="profile_button message_button"><a href="#" class="pop_guest_click">Message</a></div>';
    
      }
  
      

      echo '<div id="add_to_favorites" class="profile_button ';
        echo 'add_favorite_button';
 
      
      echo '"><span class="pop_guest_click">Add to Favorites</span>';

    echo '</div>';

    if ($isCeleb) {
      echo '</div>'; //CLOSE THE CONTAINER FOR BUTTONS ON CELEB PAGE
    }
    
  }
  else {
    echo "You are not authorized to view this profile.";
  }

  //Report User
  
  if(!$isCeleb) {
    echo '<div class="profile_button report_button"><a href="#" class="pop_guest_click">Report User</a></div>';
  }
  

  echo '</div>';  //close profile_top_bar

  //if($isCeleb) {
    echo '<div style="clear:both;"></div>';
  //}
      echo '<div id="profile_nav">
          <ul>
            <li><a class="selected" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=chart_selected">Birth Chart</a></li>';
            echo '<li><a href="#" class="pop_guest_click">House Lords</a></li>';
            if (!$isCeleb)  {
              echo '<li><a href="#" class="pop_guest_click">Photos</a></li>';
            }
            echo '<li';
            if (!$western_there) {
              echo ' class="end pop_guest_click"';
            } 
            echo '><a href="#" class="pop_guest_click">About</a></li>';
            //if ($western_there)  {        
              echo '<li class="end"><a href="#" class="pop_guest_click">Astrologers View</a></li>';
            //}
          echo '</ul>
        </div>';

      echo '<div id="profile_sections">';
      
        echo '<div id="section">';
            require('chart_others.php');
        echo '</div>'; //Close Profile sections
      echo '</div>';  //Close section
    echo '</div>'; //Close Profile Page
      //echo '<div class="profile_button compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Compare</a></div>';     

  
   //echo "<script type='text/javascript' src='js/ajax_msg_send_from_popup.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_chart_submit.js'></script>";
   //echo "<script type='text/javascript' src='js/ajax_add_favs.js'></script>";
   //echo "<script type='text/javascript' src='js/ajax_report_user.js'></script>";

//}
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
