<?php
require_once ("header.php");

  
if (login_check_point($type="full")) {

  $section = grab_var('section','chart_selected');
  $edit_profile = grab_var('edit_profile','0');

  $chart_selected = '';
  $photos_selected = '';
  $about_selected = '';
  //$western_selected = '';
  $astrologers_view_selected = '';
  
  $$section = 'selected';

  if (!get_my_chart()) {
    $no_chart = true;
  }
  
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
  <img src="/img/popTuts-view-chart-tutON.png" />
  </div>';


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

    echo '<div id="view_chart_tutorial" class="later_on pointer';
      if ($no_chart && $chart_selected == '' && $astrologers_view_selected == '') {
        echo ' no_chart';
      }
      if (!$no_chart) {
        echo ' view_chart_tutorial';
      }
    echo '">';
    if ($no_chart && (isset($_GET['section']) == 'chart_selected' ||  isset($_GET['section']) == 'astrologers_view_selected') || !isset($_GET['section'])) {
      echo '<a class="later_on" style="position:relative; top:6px; color:black;" href="#to_birth_form"><span class="div_link"></span>View Birth Chart Tutorial</a></div>';
    }
    else {
      echo 'View Birth Chart Tutorial</div>';
    }
    

// CHART POP TUT --------------------------------------

    if(my_chart_flag() == 1) {
      echo '<div id="western_circle"></div>';
      echo '<div id="why_vedic_circle"></div>';
    }

// END CHART POP TUT --------------------------------------
    echo '<div style="clear:both;"></div>';
    echo '<div id="profile_nav">';
      if(my_chart_flag() == 1) {
        echo '<a name="ct5"></a>';
      }
    echo '
        <ul>';
          //if ($no_chart) {
          //  echo '<li><a class="no_chart ' . $chart_selected . '" href="#">Birth Chart</a></li>';
          //}
          //else {
            echo '<li><a class="' . $chart_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=chart_selected">Birth Chart</a></li>';
          //}     
          //if ($no_chart) {
          //  echo '<li><a class="no_chart ' . $houses_selected . '" href="#">House Lords</a></li>';
          //}
          //else {
            echo '<li><a class="' . $houses_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=houses_selected">House Lords</a></li>';
          //}          
          echo '
          <li><a class="' . $photos_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=photos_selected">Photos</a></li>
          <li><a class="' . $about_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=about_selected">About</a></li>';
          //if ($no_chart) {
          //  echo '<li class="end"><a class="no_chart ' . $astrologers_view_selected . '" href="#">Astrologers View</a></li>';
          //}
          //else {
            echo '<li class="end"><a class="' . $astrologers_view_selected . '" href="?the_page=' . $the_page . '&the_left=' . $the_left . '&western=0&section=astrologers_view_selected">Astrologers View</a></li>';
          //}
        echo '
        </ul>
      </div>';
    
    echo '<div id="profile_sections"><a name="to_birth_form"></a>';
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
        elseif ($section == 'astrologers_view_selected') {
          require('astrologers_view.php');
        }
      echo '</div>';
    echo '</div>';
  
    
    echo '</div>';
    echo'<script type="text/javascript" src="js/ajax_descriptors_submit.js"></script>';
    if(!$no_chart) {
      echo'<script type="text/javascript" src="js/ajax_chart_submit.js"></script>';
    }
    echo'<script type="text/javascript" src="js/profile_edit.js"></script>';
    echo '<script type="text/javascript" src="js/ajax_hl_submit.js"></script>';
  //}
  
   
}
?> 
