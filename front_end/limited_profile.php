<?php
require_once ("header.php");

 //FRONT END 
//if (login_check_point($type="full")) {

  if (valid_chart_view($_GET["chart_id2"])) {
    $guest_user_id = get_guest_user_id();
    $guest_chart_id = get_guest_chart_id($guest_user_id);
    /*
    $section = grab_var('section','chart_selected');
    $western_there = grab_var('western_there',chart_already_there("Alternate",get_user_id_from_chart_id($_GET["chart_id2"])) );
    

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

       //TEST FOR ADDING text_type to compare_button
      echo '<div class="profile_button compare_button">
            <span class="compare_button_title">Compare</span>
              <select id="compare_select" onchange="location = this.options[this.selectedIndex].value;">
                <option value="">Compatiblity Test</option>
                <option value="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romance</option>
                <option value="?the_page=' . $the_page . '&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Friends</option>
              </select>
            </div>';

      if (!$isCeleb) {
        echo '<div class="profile_button chat_button"><a href="#" class="pop_guest_click">Chat</a></div>';
        //onclick="chat_all.openFullChat(' . get_user_id_from_chart_id ($_GET["chart_id2"]) . ',\'' . get_nickname (get_user_id_from_chart_id ($_GET["chart_id2"])) . '\',2)">Chat</a></div>';

        //************---Matt adding jquery popup from Message button
        echo '<div class="profile_button message_button"><a href="#" class="pop_guest_click">Message</a></div>';

        /*echo '<div id="msg_sheen" class="pop">';
    
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
                      echo '<div id="msg_sent"></div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';*/
        //***********---endMatt Stuff

        //echo '<div class="profile_button message_button"><a href="?the_page=isel&the_left=nav1&other_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">Message</a></div>';     
      }
  
      

      echo '<div id="add_to_favorites" class="profile_button ';
      /*if ($isCeleb) {
        echo 'celeb_favorites ';
      }
      if (is_my_favorite(get_user_id_from_chart_id ($_GET["chart_id2"]))) {
        echo 'remove_favorite_button';
        //$toggle = 0;
        $button_text = "Remove From Favorites";
      }
      else {*/
        echo 'add_favorite_button';
        //$toggle = 1;
        //$button_text = "Add to Favorites";
      //}
      
      echo '"><span class="pop_guest_click">Add to Favorites</span>';
      //echo '<input type="hidden" value=' . $toggle . ' name="toggle"/></div>';
      //echo 'href="toggle_favorite.php?favorite=' . $toggle . '&favorite_user_id=' . get_user_id_from_chart_id($_GET["chart_id2"]) . '">' . $button_text . '</a></div>';
      
      //if($isCeleb) {
        //echo '<input type="hidden" value=' . $other_user_id . ' name="other_user_id"/>';
      //}  
         
    echo '</div>';
    
  }
  else {
    echo "You are not authorized to view this profile.";
  }

  //Report User
  
  if(!$isCeleb) {
    echo '<div class="profile_button report_button"><a href="#" class="pop_guest_click">Report User</a></div>';
        /*echo '<div id="msg_sheen" class="pop_report">';
    
          echo '<div id="msg_sheen_screen" class="pop_report">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content_report" class="pop_report">';
                echo '<div id="msg_type_area">';
                  echo '<form id="report_user" action="chat/report_user.php" method="POST">
                          <div class="report_text"><strong>Report User</strong><br/><br/></div>
                          <div class="report_text">You are about to report ' . get_nickname($other_user_id) . ' for violating our <a href="docs/termsOfUse.htm" target="_blank">Terms of Use</a>.  <strong>All reports are strictly confidential.</strong><br/><br/></div>
                          <label for="additional_comments" id="comments_label"><strong>Additional Comments</strong> (not required)</label><br/>
                          <textarea maxlength="500" name="additional_comments" id="additional_comments"></textarea><br/>
                          <input type="submit" name="submit" value="Send" class="report_send"/>
                          <button type="button" name="cancel" class="report_cancel">Cancel</button>
                          <input type="hidden" value=' . $other_user_id . ' name="other_user_id"/>
                          <input type="hidden" value=' . get_my_user_id() . ' name="my_user_id"/>                       
                        </form>';
                      echo '<div id="report_sent"></div>';
                      echo '<div id="report_close"><button type="button" name="close" class="report_close">Close</button></div>';
                  echo '</div>';
                echo '</div>';*/
              echo '</div>';
  }
  

  echo '</div>';  //close profile_top_bar
  /*
  //SIGN UP POPUP
    echo '<div id="msg_sheen" class="pop_guest">';
    
          echo '<div id="msg_sheen_screen" class="pop_guest">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content" class="pop_guest">';
                echo '<div id="msg_type_area">';
                  echo '<form id="sign_up" action="" method="POST">
                          <div class="report_text"><strong>Sign up!</strong><br/><br/></div>
                          
                          <input type="submit" name="submit" value="Sign Up" class="sign_up"/>
                          <button type="button" name="cancel" class="sign_up_cancel">Cancel</button>
                                                
                        </form>';
                      echo '<div id="report_sent"></div>';
                      echo '<div id="report_close"><button type="button" name="close" class="report_close">Close</button></div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';
        */

  if($isCeleb) {
    echo '<div style="clear:both;"></div>';
  }
      echo '<div id="profile_nav">
          <ul>
            <li><a class="selected" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&chart_id2=' . $_GET['chart_id2'] . '&western=0&tier=3&section=chart_selected">Birth Chart</a></li>';
            echo '<li><a href="#" class="pop_guest_click">House Lords</a></li>';
            if (!$isCeleb)  {
              echo '<li><a href="#" class="pop_guest_click">Photos</a></li>';
            }
            echo '<li';
            //if (!$western_there) {
              //echo ' class="end"';
            //} 
            echo '><a href="#" class="pop_guest_click">About</a></li>';
            //if ($western_there)  {        
              echo '<li class="end"><a href="#" class="pop_guest_click">Western View</a></li>';
            //}
          echo '</ul>
        </div>';

      echo '<div id="profile_sections">';
      
        echo '<div id="section">';
          //if ($section == 'chart_selected') {
            require('chart_others.php');
          //}
          /*
          elseif ($section == 'houses_selected') {
            //require('houses_others.php');
            echo '<div style="height:300px;">Coming Soon...</div>';
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
          elseif ($section == 'western_selected') {
            require('chart_others.php');
          }
          */
        echo '</div>';
      echo '</div>';
 
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
