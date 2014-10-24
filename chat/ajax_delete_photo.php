<?php
	require_once('ajax_header.php');

	if(isset($_POST['p_id'])) {
		$data = array();
		$errors = array();
		$user_id = get_my_user_id();
		$p_ids = get_my_photo_ids();
		$photo_id_array = array();
  		while($p_id = mysql_fetch_array($p_ids)) {
    		array_push($photo_id_array, $p_id[0]);
  		}
  		if (in_array($_POST['p_id'], $photo_id_array)) {
  			$photo_id = $_POST['p_id'];
        $data['d_p_id'] = $photo_id;
  			//$data['in_array'] = 'This photo is mine';
  		}
  		else {
  			$errors['not_mine'] = 'This ain\'t mine...';
   		}
   		if (!valid_photo($photo_id, $user_id)) {
   			$errors['valid'] = 'Not a valid photo';
   		}

   		if (!empty($errors)) {
   			$data['errors'] = $errors;
   		}
   		else {
   			if (delete_photo ($photo_id, $user_id)) {
      			log_this_action (profile_action_photos(), deleted_basic_action(), $user_id);
      			//$data['success'] = true;
            $data['url'] = 'main.php?the_left=nav1&the_page=psel&section=photos_selected';
    		}
    		else {
    			$data['failed'] = 'There was an error deleting this photo.  Please refresh and try again.';
    		}
   		}
   		echo json_encode($data);
	}

	
?>