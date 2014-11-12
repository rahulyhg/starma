<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

  $section = grab_var('section','chart_selected');
  $edit_profile = grab_var('edit_profile','0');

  $chart_selected = '';
  $photos_selected = '';
  $about_selected = '';
  $western_selected = '';
  
  $$section = 'selected';
  
  log_this_action (profile_action_profile(), viewed_basic_action());

  $unc_photos = uncropped_photos(get_my_user_id());
  //print_r($unc_photos);
  if ($photo_to_crop = mysql_fetch_array($unc_photos)) {

    echo '<div id="msg_sheen" class="crop_pop">';    
    echo '<div id="msg_sheen_screen" class="crop_pop"></div>';
      echo '<div id="msg_sheen_content" class="crop_pop">';
        echo '<div id="crop_box">';
              echo '<form action="crop_photo.php" method="post" name="crop_photo_form">';
                show_photo_cropper_sign_up($photo_to_crop);
                echo '<input type="hidden" name="imgName" value="' . $photo_to_crop["picture"] . '"/>';
                echo '<input type="hidden" name="imgID" value="' . $photo_to_crop["user_pic_id"] . '"/>';
              echo '</form>';
        echo '</div>'; //close crop_box
      echo '</div>'; //close msg_sheen_content
  echo '</div>'; //close msg_sheen
  }

      //echo '<div style="position:relative; top:3px">';
        //flare_title ("Crop Your Photo");
      //echo '</div>';
        /*
      echo '<div id="photo_cropper">';
        echo '<form action="crop_photo.php" method="post" name="crop_photo_form">';
          show_photo_cropper($photo_to_crop);
          echo '<input type="hidden" name="imgName" value="' . $photo_to_crop["picture"] . '"/>';
          echo '<input type="hidden" name="imgID" value="' . $photo_to_crop["user_pic_id"] . '"/>';
        echo '</div>';
      echo '</div>'*/
      
  //}
  //else {

    echo '<div id="profile_page" class="my_page">';
    //echo '<div class="header">';
      //echo 'Profile';
      //flare_title('Profile');
    //echo '</div>';
    
    echo '<div id="profile_photo_and_info">';
      show_my_main_photo();
      show_my_general_info();
    echo '</div>';
  
    //echo '<div id="profile_photo_grid">';
    //    show_my_photo_grid($link=0);
    //  echo '</div>';
 
    show_my_descriptors_info(); 


    //************ Edit current location popup **********************//
    echo '<div id="msg_sheen" class="location_pop">';
    
          echo '<div id="msg_sheen_screen" class="location_pop">';
    
            echo '</div>';
              echo '<div id="msg_sheen_content" class="location_pop">';
                show_current_location_form();
                      echo '<div id="msg_sent"></div>';
                  echo '</div>';
                echo '</div>';
              echo '</div>';

      //End edit current location


// CHART POP TUT --------------------------------------

    if(my_chart_flag() == 1) {
      echo '<div id="western_circle"></div>';
      echo '<div id="why_vedic_circle"></div>';
    }

// END CHART POP TUT --------------------------------------

    echo '<div id="profile_nav">
        <ul>
          <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=chart_selected">Birth Chart</a></li>     
          <li><a class="' . $houses_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=houses_selected">House Lords</a></li>
          <li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=photos_selected">Photos</a></li>
          <li><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=about_selected">About</a></li>
          <li class="end"><a class="' . $western_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=1&section=western_selected">Western View</a></li>
        </ul>
      </div>';
    
    echo '<div id="profile_sections">';
     /* echo '<div id="profile_nav">
        <ul>
          <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=chart_selected">Birth Chart</a></li>
          <li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=photos_selected">Photos</a></li>
          <li><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=about_selected">About</a></li>
          <li class="end"><a class="' . $western_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=1&section=western_selected">Western View</a></li>
        </ul>
      </div>';*/
      echo '<div id="section">';
        if ($section == 'chart_selected') {
          require('chart.php');
        }
        elseif($section =='houses_selected') {
          require('houses.php');
          //echo '<div style="height:300px;">Coming Soon...</div>';
        }
        elseif ($section == 'photos_selected') {
          require('photos.php');
        }
        elseif ($section == 'about_selected') {
          
          if ($edit_profile == '0') {
            //echo '<div style="width:100%; position:relative; top:75px">';
              show_my_interests_info();
            //echo '</div>';
            echo '<input style="position:absolute; right: 20px; top: 18px;" type="button" onclick="window.location=\'?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=about_selected&edit_profile=1\'" value="Edit My Info"/>';

            
          }
          else {
            require('interests.php');
          }
          
        }
        elseif ($section == 'western_selected') {
          require('chart.php');
        }
      echo '</div>';
    echo '</div>';
  
    
    echo '</div>';
    echo'<script type="text/javascript" src="js/ajax_descriptors_submit.js"></script>';
    echo'<script type="text/javascript" src="js/ajax_chart_submit.js"></script>';
    echo'<script type="text/javascript" src="js/profile_edit.js"></script>';
    echo '<script type="text/javascript" src="js/ajax_hl_submit.js"></script>';
  //}
  
   
}
?> 
