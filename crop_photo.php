<?php
require_once ("header.php");


if (login_check_point($type="full", $domain=$domain)) {
  
  $error=0;
  if (isset($_POST["submit"])) { // IF A PHOTO HAS BEEN CROPPED AND POSTED IN
        $imgName = $_POST["imgName"];
        $imgPath = ORIGINAL_IMAGE_PATH() . $imgName;
        $x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
        //echo PROFILE_IMAGE_PATH() . $imgName;
        //die();
        $cropped_profile = resizeCroppedImage(PROFILE_IMAGE_PATH() . $imgName, $imgPath,$w,$h,$x1,$y1,maxHeight() / $h);
        $cropped_thumbnail = resizeCroppedImage(THUMBNAIL_IMAGE_PATH() . $imgName, $imgPath,$w,$h,$x1,$y1,maxHeight_thumb() / $h);
        $cropped_compare = resizeCroppedImage(COMPARE_IMAGE_PATH() . $imgName, $imgPath,$w,$h,$x1,$y1,maxHeight_compare() / $h);

        //associate_photo_with_user($imgName, get_my_user_id());
        set_photo_cropped_status($_POST["imgID"], get_my_user_id(), 0); 
        
  }

  if ($error == 0) {
    log_this_action (profile_action_photos(), uploaded_basic_action());
    do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel');
  }
  else {
      do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel&error=' . $error);
  }

}
?> 