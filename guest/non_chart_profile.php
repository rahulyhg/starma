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

      echo '<div id="compare_menu">Compare';
        echo '<div class="dropdown">';
          echo '<ul>';
            echo '<li><a href="main.php?the_page=cosel&the_left=' . $the_left . '&results_type=major&text_type=2&tier=2&stage=2&chart_id1=' . $guest_chart_id . '&chart_id2=861&from_profile=true">As Friends</a></li>';
            echo '<li><a style="border-bottom:1px solid black;" href="main.php?the_page=cosel&the_left=' . $the_left . '&results_type=major&text_type=1&tier=2&stage=2&chart_id1=861&chart_id2=' . $_GET["chart_id2"] . '&from_profile=true">Romantically</a></li>';
          echo '</ul>';
        echo '</div>';
      echo '</div>';
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
