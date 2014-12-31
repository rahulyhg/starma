<?php
require_once ("header.php");

  
//if (login_check_point($type="partial", $domain=$domain)) {

  //$data = array();

  if ( isset($_POST["firsttime"])) {
    $firsttime = $_POST["firsttime"];
  }
  else { 
    $firsttime = 0;
  }
  if(isset($_POST['desc1'])) {
    $_SESSION['word_1'] = trim($_POST['desc1']);
  }
  if(isset($_POST['desc2'])) {
    $_SESSION['word_2'] = trim($_POST['desc2']);
  }
  if(isset($_POST['desc3'])) {
    $_SESSION['word_3'] = trim($_POST['desc3']);
  }

  
  $error=0;

  if($_FILES['image']['name'] && num_my_photos() < max_photos()) {
    if ( $firsttime == 1 ) {
      if ($main_photo_id = get_my_main_photo_id()) {
        delete_photo($main_photo_id, get_my_user_id());
      }      
    }
       
    list($file,$error) = upload_no_adjust('image',ORIGINAL_IMAGE_PATH(),'jpeg,gif,png,jpg');
    if($error) {
      print $error;  
      if ($error != 'bad_picture') {
        $error = 4;
      }
      else {
        $error = 5;
      }
      
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
      do_redirect ( get_domain() . '/main.php?the_left=nav1&the_page=psel&section=photos_selected');
    }
    else { 
      //do_redirect ( get_domain() . '/desc_photo_first_time.php');
      do_redirect ( get_domain() .'/sign_up.php?crop');
    }
  }
  else {
   
    if ($firsttime == 0) {
      do_redirect ( get_domain() . '/main.php?the_left=nav1&the_page=psel&section=photos_selected&error=' . $error);
    }
    else { 
      do_redirect ( get_domain() . '/sign_up.php?&error=' . $error);
    }
  }

//}
?> 