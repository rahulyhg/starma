<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

log_this_action (profile_action_photos(), viewed_basic_action());

  show_upload_photo_box();
    /*
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
    */
      //echo '<div style="position:relative; top:3px">';
      //  flare_title ("Edit Photos");
      //echo '</div>';
      //echo 'NUM MY PHOTOS: ' . num_my_photos();
      echo '<div id="photos">';
      //upload_photo_form();
      show_my_photo_grid();
      /*
      if (isset($_GET["error"])) {
        if ($_GET['error'] == 1) {
          echo '<input type="hidden" value="1" id="p_err_1" />';
        }
        if ($_GET['error'] == 2) {
          echo '<input type="hidden" value="2" id="p_err_2" />';
        }
        if ($_GET['error'] == 3) {
          echo '<input type="hidden" value="3" id="p_err_3" />';
        }
        if ($_GET['error'] == 4) {
          echo '<input type="hidden" value="4" id="p_err_4" />';
        }
        */
        /*
        echo '<div id="photo_error">';
          if ($_GET["error"] == 1) {
            echo "Error Deleting Photo.  Please contact Starma.com Administration.";
          }
          elseif ($_GET["error"] == 2) {
            echo "You have reached the " . max_photos() . " maximum allowed profile photos.";
          }
        echo '</div>';
        */
      }
   // }
    echo '<input type="hidden" value="';
      if (isset($_GET["error"])) {  
        if ($_GET['error'] == 1) {
          echo '1';
        }
        if ($_GET['error'] == 2) {
          echo '2';
        }
        if ($_GET['error'] == 3) {
          echo '3';
        }
        if ($_GET['error'] == 4) {
          echo '4';
        }
      }
      else {
        echo '0';
      }

    echo '" id="p_err_id" />';
    echo '</div>';  //close wrapper
    
}

?> 
