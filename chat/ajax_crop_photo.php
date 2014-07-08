<?php
require_once("ajax_header.php");
 
if (isLoggedIn() == true) {
   $errors = array();
   $imgName = $_POST["imgName"];
   $imgPath = '../' . ORIGINAL_IMAGE_PATH() . $imgName;

   if (num_my_photos() < max_photos()) {
          $x1 = $_POST["x"];
    	  $y1 = $_POST["y"];
	  $w = $_POST["w"];
	  $h = $_POST["h"];
          //echo PROFILE_IMAGE_PATH() . $imgName;
          //die();
          $cropped_profile = resizeCroppedImage('../' . PROFILE_IMAGE_PATH() . $imgName, (string)$imgPath,$w,$h,$x1,$y1,maxHeight() / $h);
          $cropped_thumbnail = resizeCroppedImage('../' . THUMBNAIL_IMAGE_PATH() . $imgName, $imgPath,$w,$h,$x1,$y1,maxHeight_thumb() / $h);
          $cropped_compare = resizeCroppedImage('../' . COMPARE_IMAGE_PATH() . $imgName, $imgPath,$w,$h,$x1,$y1,maxHeight_compare() / $h);

          //associate_photo_with_user($imgName, get_my_user_id());
          set_photo_cropped_status($_POST["imgID"], get_my_user_id(), 0); 
   }
   else {
     $errors[] = "Too Many Photos";
   }            
  
   $data['errors'] = $errors;
   echo json_encode($data);
 
} 

 

 
?> 