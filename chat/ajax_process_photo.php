<?php
	require_once('ajax_header.php');

	$data = array();
	$errors = array();

	if($_FILES['image']['name'] && num_my_photos() < max_photos()) {
		list($file,$error) = upload_no_adjust('image',ORIGINAL_IMAGE_PATH(),'jpeg,gif,png,jpg');
	 	if($error) {
      		//print $error;
      		//$error = 4;
      		$errors['valid'] = 'Please upload a valid file.';
    	}
    	else {
      		if (!associate_photo_with_me($file)) {
        		//$error = 1; 
        		$errors['assoc'] = 'There was an error uploading.  Please try again.';
        		//LOG THE UPLOAD, BUT INDICATE THAT IT COULDNT BE ASSOCIATED
        		log_this_action (profile_action_photos(), uploaded_basic_action(), -5);
      		}    
    	}        
  	}
  	else {
    	if (!$_FILES['image']['name']) {
      		//$error = 3;
      		$errors['none'] = 'Please select a photo.';
    	}
   		else {
      		//$error = 2;
      		$errors['max'] = 'You alread have the maximum of ' . max_photos() . '. Please delete one to upload this photo.';
    	}
    }

   	if (!empty($errors)) {
   		$data['errors'] = $errors;
   	}
   	else {
   		log_this_action (profile_action_photos(), uploaded_basic_action());
   		$data['url'] = 'main.php?the_left=nav1&the_page=psel&section=photos_selected';
   	}

   	echo json_encode($data);


    

?>