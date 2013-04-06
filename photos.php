<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {

log_this_action (profile_action_photos(), viewed_basic_action());

//if (isset($_GET["edit"])) {
//  $edit = $_GET["edit"];
//}
//elseif (!is_my_profile_done()) {
//  $edit = 1;
//}
//else {
//  $edit = 0; 
//}

//  if ($edit == 0) {
//    show_photos();
//  }
//  else {
    echo '<div style="position:relative; top:3px">';
      flare_title ("Edit Photos");
    echo '</div>';
    //echo 'NUM MY PHOTOS: ' . num_my_photos();
    upload_photo_form();
//  }
    if (isset($_GET["error"])) {
      echo '<div id="photo_error">';
        if ($_GET["error"] == 1) {
          echo "Error Deleting Photo.  Please contact Starma.com Administration.";
        }
        elseif ($_GET["error"] == 2) {
          echo "You have reached the " . max_photos() . " maximum allowed profile photos.";
        }
      echo '</div>';
    }
    
}

?> 
