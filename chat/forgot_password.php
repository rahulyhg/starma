<?php

require_once('ajax_header.php');

	$data = array();
	$errors = array();

	//echo json_encode($data);
	$fp_email = trim($_POST['fp_email']);
	$fp_email = lostPassword($fp_email);
	if ($fp_email) {
		if ($fp_email == 'success'){
			$data['message'] = 'A temporary password has been sent to your email';
		}
		elseif ($fp_email == 'wrong_email') {
			$errors['message'] = 'Sorry! We were unable to find your email';
		}
		elseif ($fp_email == 'user_not_there') {
			$errors['message'] = 'Sorry! We were unable to find a user account matching your email';
		}
		elseif ($fp_email == 'sending_error') {
			$errors['message'] = 'Sorry! We were unable to send a new password at this time.  Please try again.';
		}
		elseif ($fp_email == 'update_error') {
			$errors['message'] = 'Sorry! We were unable to update your password at this time.  Please try again.';
		}
		
		else {
 			$errors['message'] = 'Sorry! We were unable to find your email';
		}
		
	}
	else {
		$errors['message'] = 'Please enter your email';
	}

	if(!empty($errors)) {
		$data['errors'] = $errors;
	}
	else {
		$data['success'] = true;
	}

	echo json_encode($data);
	
?>