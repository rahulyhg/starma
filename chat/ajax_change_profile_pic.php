<?php
	require_once('ajax_header.php');

	if (isset($_POST["p_id"])) {
		$data = array();
		$errors = array();
		$p_ids = get_my_photo_ids();
		$photo_id_array = array();
  		while($p_id = mysql_fetch_array($p_ids)) {
    		array_push($photo_id_array, $p_id[0]);
  		}
  		if (in_array($_POST['p_id'], $photo_id_array)) {
  			$photo_id = $_POST['p_id'];
  			//$data['message'] = 'In array!';
  			if (!$data['main_id'] = get_my_main_photo_id()) {
  				$errors['main_id'] = 'There was an error with your main_id.  Please try again';
  			}
  			if (!$data['old_picture'] = get_my_specific_picture($data['main_id'])) {
  				$errors['old_picture'] = 'There was an error with your old picture.  Please try again.';
  			}
  			if (valid_photo($photo_id, get_my_user_id())) {
   			 	change_my_profile_pic($photo_id);
   			 	log_this_action (profile_action_photos(), editted_basic_action());
   			}
  			else {
  				$errors['update'] = 'There was an error updating your profile pic.  Please try again.';
  			}
  			if (!$data['picture'] = get_my_picture_number($photo_id)) {
  				$errors['picture'] = 'There was an error getting changing your profile pic.  Please refresh the page.';
  			}
  			
  			/*
  			if ($data['picture'] = get_my_picture_number($photo_id)) {
  				$data['success'] = true;
    			$data['message'] = 'Success!';
  			}
  			else {
  				$errors['picture'] = 'There was an error getting changing your profile pic.  Please refresh the page.';
  			}
			*/
  		}
  		else {
  			$errors['not_mine'] = 'That picture ain\'t mine...';
  		}
  		if(!empty($errors)) {
  			$data['errors'] = $errors;
  		}
  		else {
  			$data['success'] = true;
    		//$data['message'] = 'Success!';
  		}

  echo json_encode($data);
   
}


?>