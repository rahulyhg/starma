<?php
require_once ("header.php");

  
if (login_check_point($type="partial", $domain=$domain)) {

  if ( isset($_POST["firsttime"])) {
    $firsttime = $_POST["firsttime"];
  }
  else { 
    $firsttime = 0;
  }
  
  $error=0;

  if($_FILES['image']['name'] && num_my_photos() < max_photos()) {
        if ( $firsttime == 1 ) {
            if ($main_photo_id = get_my_main_photo_id()) {
              delete_photo($main_photo_id, get_my_user_id());
            }
            $_SESSION["des_name_1"] = $_POST["des_name_1"];
            $_SESSION["des_name_2"] = $_POST["des_name_2"];
            $_SESSION["des_name_3"] = $_POST["des_name_3"];
            echo '*' . $_POST["des_name_1"] . '*';
          
        }
       
	list($file,$error) = upload_no_adjust('image',ORIGINAL_IMAGE_PATH(),'jpeg,gif,png,jpg');
	if($error) {
           print $error;
           $error = 4;
        }
        else {
          if (!associate_photo_with_me($file)) {
            $error = 1; 
            //LOG THE UPLOAD, BUT INDICATE THAT IT COULDNT BE ASSOCIATED
            log_this_action (profile_action_photos(), uploaded_basic_action(), -5);
          }
        }
        
  }
  else {
    if (!$_FILES['image']['name']) {
      $error = 3;
    }
    else {
      $error = 2;
    }
  }
  if ($error == 0) {
    log_this_action (profile_action_photos(), uploaded_basic_action());
    if ($firsttime == 0) {
      do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel');
    }
    else { 
      do_redirect ( get_domain() . '/desc_photo_first_time.php');
    }
  }
  else {
   
    if ($firsttime == 0) {
      do_redirect ( get_domain() . '/main.php?the_left=nav4&the_page=psel&error=' . $error);
    }
    else { 
      do_redirect ( get_domain() . '/desc_photo_first_time.php?error=' . $error);
    }
  }

}
?> 
