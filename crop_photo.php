<?php
require_once ("header.php");

  
if (login_check_point($type="full", $domain=$domain)) {
  $error=0;
  if (isset($_POST["submit"])) { // IF A PHOTO HAS BEEN CROPPED AND POSTED IN
        $imgPath = $_POST["imgPath"];
        $path_arr = split(ORIGINAL_IMAGE_PATH(),$imgPath);
        $file_name = strtolower($path_arr[count($path_arr)-1]);
        $x1 = $_POST["x1"];
	$y1 = $_POST["y1"];
	$x2 = $_POST["x2"];
	$y2 = $_POST["y2"];
	$w = $_POST["w"];
	$h = $_POST["h"];
        
        $cropped_profile = resizeImage(PROFILE_IMAGE_PATH() . $file_name, $imgPath,$w,$h,$x1,$y1,maxWidth() / $w);\
        $cropped_thumbnail = resizeImage(THUMBNAIL_IMAGE_PATH() . $file_name, $imgPath,$w,$h,$x1,$y1,maxWidth_thumb() / $w);
        $cropped_compare = resizeImage(COMPARE_IMAGE_PATH() . $file_name, $imgPath,$w,$h,$x1,$y1,maxWidth_compare() / $w);
        
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
