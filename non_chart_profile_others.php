<?php
require_once ("header.php");

//TEST CHANGE!
  
if (login_check_point($type="full")) {

  if (valid_chart_view($_GET["chart_id2"])) {
    $section = grab_var('section','chart_selected');
    $western_there = grab_var('western_there',chart_already_there("Alternate",get_user_id_from_chart_id($_GET["chart_id2"])) );
    $isCeleb = grab_var('isCeleb',isCeleb(get_user_id_from_chart_id ($_GET["chart_id2"])));

    $chart_selected = '';
    $photos_selected = '';
    $about_selected = '';
    //$western_selected = '';
    $astrologers_view_selected = '';
  
    $$section = 'selected';
    $$tab = 'not_selected';

    //*************---Matt adding msg popup from Message button
    
    if (isset($_GET['chart_id1'])) {
      $chart_id1 = $_GET["chart_id1"];
    }

    $chart_id2 = $_GET["chart_id2"];
    $other_user_id = get_user_id_from_chart_id ($chart_id2);

    if (!get_my_chart()) {
      $no_chart = true;
    }

    echo '<div id="img_preloader">
    <img src="/img/Starma-Astrology-Compare-ButtonON.png"/> 
    <img src="/img/Starma-Astrology-Report-UserON.png"/> 
    <img src="/img/profile/Starma-Astrology-MessageON.png"/>
    <img src="/img/profile/Starma-Astrology-ChatON.png"/>
    <img src="/img/profile/Starma-Astrology-FavoritesON.png"/>
    <img src="/img/hl_nav_icon_1ON.png"/>
    <img src="/img/hl_nav_icon_2ON.png"/>
    <img src="/img/hl_nav_icon_3ON.png"/>
    <img src="/img/hl_nav_icon_4ON.png"/>
    <img src="/img/hl_nav_icon_5ON.png"/>
    <img src="/img/hl_nav_icon_6ON.png"/>
    <img src="/img/hl_nav_icon_7ON.png"/>
    <img src="/img/hl_nav_icon_8ON.png"/>
    <img src="/img/hl_nav_icon_9ON.png"/>
    <img src="/img/hl_nav_icon_10ON.png"/>
    <img src="/img/hl_nav_icon_11ON.png"/>
    <img src="/img/hl_nav_icon_12ON.png"/>

    <img src="/img/houseIcon_1.png"/>
    <img src="/img/houseIcon_2.png"/>
    <img src="/img/houseIcon_3.png"/>
    <img src="/img/houseIcon_4.png"/>
    <img src="/img/houseIcon_5.png"/>
    <img src="/img/houseIcon_6.png"/>
    <img src="/img/houseIcon_7.png"/>
    <img src="/img/houseIcon_8.png"/>
    <img src="/img/houseIcon_9.png"/>
    <img src="/img/houseIcon_10.png"/>
    <img src="/img/houseIcon_11.png"/>
    <img src="/img/houseIcon_12.png"/>
  
    <img src="/img/palanquin_1.png" />
    <img src="/img/palanquin_2.png" />
    <img src="/img/palanquin_3.png" />
    <img src="/img/palanquin_4.png" />
    <img src="/img/palanquin_5.png" />
    <img src="/img/palanquin_6.png" />
    <img src="/img/palanquin_7.png" />
    <img src="/img/palanquin_8.png" />
    <img src="/img/palanquin_9.png" />
    <img src="/img/palanquin_10.png" />
    <img src="/img/palanquin_11.png" />
    <img src="/img/palanquin_12.png" />
    </div>';

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

       //TEST FOR ADDING text_type to compare_button <span class="compare_button_title">Compare</span>


    echo '<div class="profile_button compare_button">';
      echo '<div style="position:relative; top:32px; left:5px; text-align:center;">';
        if ($no_chart) {
          echo '<a href="#" title="Compare" class="no_chart">Compare<span class="div_link"></span></a>';
        }
        else {
          echo '<a href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Compare<span class="div_link"></span></a>';
        }
      echo '</div>';
      /*
      echo '<div id="compare_menu"><a href="">Compare</a>';
        echo '<div class="dropdown">';
          echo '<ul>';
            echo '<li><a href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">As Friends</a></li>';
            echo '<li><a style="border-bottom:1px solid black;" href="main.php?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romantically</a></li>';
          echo '</ul>';
        echo '</div>';
      echo '</div>';
    */
    echo '</div>'; //Close compare_button
  

      if (!$isCeleb) {
        echo '<div class="profile_button chat_button"><a href="#" onclick="chat_all.openFullChat(' . get_user_id_from_chart_id ($_GET["chart_id2"]) . ',\'' . get_nickname (get_user_id_from_chart_id ($_GET["chart_id2"])) . '\',2)">Chat</a></div>';

        //************---Matt adding jquery popup from Message button
        echo '<div class="profile_button message_button"><a href="#" id="msg_pop">Message</a></div>';
        echo '<div id="msg_sheen" class="pop">';
    
          echo '<div id="msg_sheen_screen" class="pop">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content" class="pop">';
                echo '<div id="msg_type_area">';
                  echo '<div id="send_message_area">';
                  //echo '<form id="send-message-area" action="chat/send_msg_from_profile.php" method="POST">
                    echo '<div id="msg_label">New Message</div>
                          <textarea id="msg_sendie" name="text_body" maxlength = "500" ></textarea>
                          <div id="send_msg">Send</div>
                          <div id="cancel_msg">Cancel</div>
                          <input type="hidden" value=' . $other_user_id . ' name="other_user_id"/>';
                          //<input type="hidden" value=' . $chart_id1 . ' name="chart_id1"/>
                          //<input type="hidden" value=' . $chart_id2 . ' name="chart_id2"/>';                         
                      //echo '</form>';
                      echo '</div>';
                      echo '<div id="msg_sent"></div>';
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
      
      if($isCeleb) {
        echo '<input type="hidden" value=' . $other_user_id . ' name="other_user_id"/>';
      }  
         
    echo '</div>'; //Close add/remove favs button
//echo '</div>';  //MYSTERIOUS FIX FOR FOOTER...
  }
  else {
    echo "You are not authorized to view this profile.";
  }

  //Report User
 //echo '</div><!--MYSTERY-->';  //MYSTERIOUS FIX FOR FOOTER... 
  if(!$isCeleb) {
    echo '<div class="profile_button report_button"><a href="#" id="report_pop">Report User</a></div>';
        echo '<div id="msg_sheen" class="pop_report">';
    
          echo '<div id="msg_sheen_screen" class="pop_report">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content_report" class="pop_report">';
                echo '<div id="msg_type_area">';
                echo '<div id="report_user">';
                  //echo '<form id="report_user" action="chat/report_user.php" method="POST">
                    echo '<div class="heading">Report User</div>
                          <div>You are about to report ' . get_nickname($other_user_id) . ' for violating our <a href="docs/termsOfUse.htm" target="_blank">Terms of Use</a>.  <strong>All reports are strictly confidential.</strong><br/><br/></div>
                          <div id="comments_label">Additional Comments (not required)</div>
                          <textarea maxlength="500" name="additional_comments" id="additional_comments"></textarea><br/>
                          <div id="send_report">Send</div> 
                          <div id="cancel_report">Cancel</div>                        
                          <input type="hidden" value=' . $other_user_id . ' name="other_user_id"/>
                          <input type="hidden" value=' . get_my_user_id() . ' name="my_user_id"/>';
                        echo '</div>';                       
                      //echo '</form>';
                      echo '<div id="report_sent"></div>';
                      echo '<div id="close_report">Close</div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
  }
  
echo '</div>';  //MYSTERIOUS FIX FOR FOOTER...

  echo '</div>';  //close profile_top_bar
  //echo '</div>';  //MYSTERIOUS FIX FOR FOOTER...
  //if($isCeleb) {
    echo '<div style="clear:both;"></div>';
  //}
      echo '<div id="profile_nav">
          <ul>
            <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=chart_selected">Birth Chart</a></li>';
            echo '<li><a class="' . $houses_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=houses_selected">House Lords</a></li>';
            if (!$isCeleb)  {
              echo '<li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=photos_selected">Photos</a></li>';
            }
            echo '<li><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=about_selected">About</a></li>';
            echo '<li class="end"><a class="' . $astrologers_view_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left .'&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=astrologers_view_selected">Astrologers View</a></li>';
            /*
            echo '<li';
            if (!$western_there) {
              echo ' class="end"';
            } 
            echo '><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=about_selected">About</a></li>';
            if ($western_there)  {        
              echo '<li class="end"><a class="' . $western_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=1&tier=3&section=western_selected">Western View</a></li>';
            }
            */
          echo '</ul>
        </div>';
  //echo '</div>';  //MYSTERIOUS FIX FOR FOOTER...

      echo '<div id="profile_sections">';
      
        echo '<div id="section">';
          if ($section == 'chart_selected') {
            require('chart_others.php');
          }
          elseif ($section == 'houses_selected') {
            require('houses.php');
            //echo '<div style="height:300px;">Coming Soon...</div>';
          }
          elseif (($section == 'photos_selected') && (!$isCeleb)) {
            require('photos_others.php');
          }
          elseif ($section == 'about_selected') {
            if ($isCeleb) {
              show_interests_info($_GET["chart_id2"], $isCeleb);
            }
            else {
            //echo '<div style="position:relative; top:75px;width:100%;">';
              show_interests_info($_GET["chart_id2"], false);
            //echo '</div>';   
            }
          }
          elseif ($section == 'astrologers_view_selected') {
            require ('astrologers_view.php');
          }

          //elseif ($section == 'western_selected') {
          //  require('chart_others.php');
          //}
        echo '</div>';
      echo '</div>';

      //echo '<div class="profile_button compare_button"><a href="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&tier=2&stage=2&chart_id1=' . get_my_chart_id() . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Compare</a></div>';     

     
  //echo '</div>';  //MYSTERIOUS FIX FOR FOOTER...
   echo "<script type='text/javascript' src='js/ajax_msg_send_from_popup.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_chart_submit.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_add_favs.js'></script>";
   echo "<script type='text/javascript' src='js/ajax_report_user.js'></script>";
   echo '<script type="text/javascript" src="js/ajax_hl_submit.js"></script>';

}
?> 
