<?php
	require_once('ajax_header.php');

	if (isLoggedIn()) {
		$data = array();
		$errors = array();
		if (isset($_POST['hlcb'])) {
			$pref_name = 'hl_private';
			if (!preg_match('%^[\d]{1}$%', $_POST['hlcb'])) {
				$errors['invald'] = 'There was an error. Please refresh and try again.';
			}
			else {
				$hlcb = $_POST['hlcb'];
				//$data['hlcb'] = $hlcb;
				//$data['msg'] = $hlcb;
			}
			if (!set_my_preference($pref_name, $hlcb)) {
				$errors['set'] = 'Unable to set preference.  Please refresh and try again';
			}
			
			if (!empty($errors)) {
				$data['errors'] = $errors;
			}				
			else {
				$data['msg'] = 'Success!';
			}
				//$data['msg'] = is_preference_there($pref_name, get_my_user_id());
			echo json_encode($data);
		}

	}
	else {
		do_redirect(get_landing());
	}
	

?>