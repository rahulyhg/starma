<?php
require_once ("ajax_header.php");

  
//if (login_check_point($type="partial", $domain=$domain)) {

  //$data = array();
  //$errors = array();


// KEEP 3 WORDS-----------------------------------------------

  if(isset($_POST['word_1'])) {
    $_SESSION['word_1'] = trim($_POST['desc1']);
  }
  if(isset($_POST['word_2'])) {
    $_SESSION['word_2'] = trim($_POST['desc2']);
  }
  if(isset($_POST['word_3'])) {
    $_SESSION['word_3'] = trim($_POST['desc3']);
  }



  if ( isset($_POST["firsttime"])) {
    $firsttime = $_POST["firsttime"];
  }

  $error=0;

  if($_FILES['image']['name'] && num_my_photos() < max_photos()) {
        //if ( $firsttime == 1 ) {
            if ($main_photo_id = get_my_main_photo_id()) {
              delete_photo($main_photo_id, get_my_user_id());
            }
            //$_SESSION["des_name_1"] = $_POST["des_name_1"];
            //$_SESSION["des_name_2"] = $_POST["des_name_2"];
            //$_SESSION["des_name_3"] = $_POST["des_name_3"];
            //echo '*' . $_POST["des_name_1"] . '*';
          
        //}


       
	list($file,$error) = upload_no_adjust('image',ORIGINAL_IMAGE_PATH(),'jpeg,gif,png,jpg');
	if($error) {
           print $error;
           $error = 'Not a valid file';
           //$errors['valid'] = 'Not a valid file';
        }
        else {
          if (!associate_photo_with_me($file)) {
            $error = 'Cannot associate'; 
            //$errors['associate'] = 'Cannot link photo to profile, please try again';
            //LOG THE UPLOAD, BUT INDICATE THAT IT COULDNT BE ASSOCIATED
            log_this_action (profile_action_photos(), uploaded_basic_action(), -5);
          }
          
        }
        
  }
  else {
    if (!$_FILES['image']['name']) {
      $error = 'Not file';
      //$errors['not_there'] = 'No file selected';
    }
    else {
      $error = 'At limit';
      //$errors['too_many'] = 'You have reached your photo limit';
    }
  }


  if ($error !== 0) {
    do_redirect( get_domain() . '/sign_up.php?2&error=' . $error);
  }
  else {
    log_this_action (profile_action_photos(), uploaded_basic_action());
    do_redirect (get_domain() . '/sign_up.php?2.5');
    //$data['url'] = 'sign_up.php?2.5'; 
    //$data['success'] = true;
  }

//}
?> 
