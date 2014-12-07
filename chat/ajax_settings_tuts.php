<?php
	require('ajax_header.php');

	if (isLoggedIn()) {
		$data = array();
		$errors = array();

	//CHART FLAG CHECKBOX
		if (isset($_POST['cfcb'])) {
			if (!preg_match('%^[\d]{1}$%', $_POST['cfcb'])) {
				$errors['invald'] = 'There was an error. Please refresh and try again.';
			}
			else {
				$cfcb = $_POST['cfcb'];
				//$data['hlcb'] = $hlcb;
				//$data['msg'] = $hlcb;
			}
			if (!set_my_chart_flag($cfcb)) {
				$errors['set'] = 'Unable to set preference.  Please refresh and try again';
			}
			
			if (!empty($errors)) {
				$data['errors'] = $errors;
			}				
			else {
				$data['msg'] = 'Success!';
			}
				//$data['msg'] = is_preference_there($pref_name, get_my_user_id());
			
		}

	//COMPARE FLAGS CHECKBOX
		if (isset($_POST['cofcb'])) {
			if (!preg_match('%^[\d]{1}$%', $_POST['cofcb'])) {
				$errors['invald'] = 'There was an error. Please refresh and try again.';
			}
			else {
				$cofcb = $_POST['cofcb'];
				//$data['hlcb'] = $hlcb;
				//$data['msg'] = $hlcb;
			}
			if (!set_my_compare_major_flag($cofcb)) {
				$errors['major_set'] = 'Unable to set preference (major compare).  Please refresh and try again';
			}

			if (!set_my_compare_minor_flag($cofcb)) {
				$errors['minor_set'] = 'Unable to set preference (minor compare).  Please refresh and try again';
			}
			
			if (!empty($errors)) {
				$data['errors'] = $errors;
			}				
			else {
				$data['msg'] = 'Success!';
			}
				//$data['msg'] = is_preference_there($pref_name, get_my_user_id());
			
		}

		echo json_encode($data);

	}
	else {
		do_redirect(get_landing());
	}
?>