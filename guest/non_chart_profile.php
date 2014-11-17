<?php
require_once ("header.php");

//**************GUEST VIEW********************//
  
//if (login_check_point($type="full")) {
$guest_user_id = get_guest_user_id();
$guest_chart_id = get_guest_chart_id($guest_user_id);
  $section = grab_var('section','chart_selected');
  //$edit_profile = grab_var('edit_profile','0');

  $chart_selected = '';
  $photos_selected = '';
  $about_selected = '';
  //$western_selected = '';
  $astrologers_view_selected = '';

  $$section = 'selected';


  echo '<div id="img_preloader">
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
  

    echo '<div id="profile_page" class="my_page">';
      echo '<div id="profile_top_bar">';

    echo '<div id="profile_photo_and_info">';
      show_main_photo($guest_chart_id);
      show_general_info($guest_chart_id);
    echo '</div>';
  
    show_descriptors_info($guest_chart_id); 


    //************ Edit current location popup **********************//
    echo '<div id="msg_sheen" class="location_pop">';
    
          echo '<div id="msg_sheen_screen" class="location_pop">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content" class="location_pop">';
                show_current_location_form();
                      echo '<div id="msg_sent"></div>';
                  echo '</div>';
                echo '</div>';
              //echo '</div>';

      //End edit current location

      //TEST FOR ADDING text_type to compare_button
      echo '<div class="profile_button compare_button">';
      echo '<div style="position:relative; top:32px; left:5px; text-align:center;">
              <a href="main.php?the_page=cosel&the_left=nav1&results_type=major&text_type=1&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=861&from_profile=true">Compare<span class="div_link"></span></a>
            </div>';
      /*
      echo '<div id="compare_menu">Compare';
        echo '<div class="dropdown">';
          echo '<ul>';
            echo '<li><a href="main.php?the_page=cosel&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=861&from_profile=true">As Friends</a></li>';
            echo '<li><a style="border-bottom:1px solid black;" href="main.php?the_page=cosel&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=861&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romantically</a></li>';
          echo '</ul>';
        echo '</div>';
      echo '</div>';
      */
    echo '</div>';

  echo '</div>'; //Close Profile top bar

  echo '<div style="clear:both;"></div>';
    echo '<div id="profile_nav">
        <ul>
          <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=chart_selected">Birth Chart</a></li>     
          <li><a class="' . $houses_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=houses_selected">House Lords</a></li>
          <li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=photos_selected">Photos</a></li>
          <li><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=about_selected">About</a></li>
          <li class="end"><a class="' . $astrologers_view_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=astrologers_view_selected">Astrologers View</a></li>
        </ul>
      </div>';


    
    echo '<div id="profile_sections">';
      echo '<div id="section">';
        if ($section == 'chart_selected') {
          if(!isLoggedIn()) {
            echo '<script type="text/javascript">
                    $(document).ready(function(){
                      $(".pop_guest").slideFadeToggle();
                    });
                  </script>';
}
          require('chart.php');
        }
        elseif($section =='houses_selected') {
          require('../houses.php');
          //echo '<div style="height:300px;">Coming Soon...</div>';
        }
        elseif ($section == 'photos_selected') {
          require('photos.php');
        }
        elseif ($section == 'about_selected') {

          show_interests_info($guest_chart_id, false);
 
        }
        elseif ($section == 'astrologers_view_selected') {
          require('astrologers_view.php');
        }
      echo '</div>';
    echo '</div>';
  
    
    echo '</div>';
    echo'<script type="text/javascript" src="js/ajax_descriptors_submit.js"></script>';
    echo'<script type="text/javascript" src="js/ajax_chart_submit.js"></script>';
    echo'<script type="text/javascript" src="js/profile_edit.js"></script>';
    echo '<script type="text/javascript" src="js/ajax_hl_submit.js"></script>';
  //}
  
   
//}
?> 
