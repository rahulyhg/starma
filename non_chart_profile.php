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
  if ($photo_to_crop = mysql_fetch_array($unc_photos)) {
      echo '<div style="position:relative; top:3px">';
        flare_title ("Crop Your Photo");
      echo '</div>';
        
      echo '<div id="photo_cropper">';
        echo '<form action="crop_photo.php" method="post" name="crop_photo_form">';
          show_photo_cropper($photo_to_crop);
          echo '<input type="hidden" name="imgName" value="' . $photo_to_crop["picture"] . '"/>';
          echo '<input type="hidden" name="imgID" value="' . $photo_to_crop["user_pic_id"] . '"/>';
        echo '</div>';
      echo '</div>';
      
  }
  else {

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
    
    echo '<div id="profile_sections"/>';
      echo '<div id="profile_nav">
        <ul>
          <li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=chart_selected">Birth Chart</a></li>
          <li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=photos_selected">Photos</a></li>
          <li><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=about_selected">About</a></li>
          <li class="end"><a class="' . $western_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=1&section=western_selected">Western View</a></li>
        </ul>
      </div>';
      echo '<div id="section"/>';
        if ($section == 'chart_selected') {
          require('chart.php');
        }
        elseif ($section == 'photos_selected') {
          require('photos.php');
        }
        elseif ($section == 'about_selected') {
          
          if ($edit_profile == '0') {
            echo '<div style="width:100%; position:relative; top:75px">';
              show_my_interests_info();
            echo '</div>';
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
  }
  
   
}
?> 
