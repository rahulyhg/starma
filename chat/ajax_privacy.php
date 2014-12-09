<?php
	require_once('ajax_header.php');

	if (isLoggedIn()) {
		$data = array();
		$errors = array();
		if (isset($_POST['hlcb'])) {
			$pref_name = 'hl_private';
			if (!preg_match('%^[\d]{1}$%', $_POST['hlcb'])) {
				$errors['invald_chartcb'] = 'There was an error. Please refresh and try again.';
			}
			else {
				$hlcb = $_POST['hlcb'];
				//$data['hlcb'] = $hlcb;
				//$data['msg'] = $hlcb;
			}
			if (!set_my_preference($pref_name, $hlcb)) {
				$errors['set_hlcb'] = 'Unable to set preference.  Please refresh and try again';
			}
			
			if (!empty($errors)) {
				$data['errors'] = $errors;
			}				
			else {
				$data['msg'] = 'Success!';
			}
				//$data['msg'] = is_preference_there($pref_name, get_my_user_id());
			
		}
        elseif (isset($_POST['chartcb'])) {
			$pref_name = 'chart_private';
			if (!preg_match('%^[\d]{1}$%', $_POST['chartcb'])) {
				$errors['invald_chartcb'] = 'There was an error. Please refresh and try again.';
			}
			else {
				$chartcb = $_POST['chartcb'];
				//$data['hlcb'] = $hlcb;
				//$data['msg'] = $hlcb;
			}
			if (!set_my_preference($pref_name, $chartcb)) {
				$errors['set_chartcb'] = 'Unable to set preference.  Please refresh and try again';
			}
            if ($chartcb == 1) {
                if (!set_my_preference('hl_private', $chartcb)) {
  					$errors['set'] = 'Unable to set sub-preference.  Please refresh and try again';
                }
            }
			
			if (!empty($errors)) {
				$data['errors'] = $errors;
			}				
			else {
				$data['msg'] = 'Success!';
			}
				//$data['msg'] = is_preference_there($pref_name, get_my_user_id());
			
		}


	//CHANGE USERNAME

		if (isset($_POST['username'])) {
			$username = trim($_POST['username']);

			$valid_username = valid_username($username);

			if($valid_username) {
				if($valid_username == 'long') {
					$data['errors'] = true;
					$data['message'] = 'Too long';
				}
				elseif($valid_username == 'short') {
					$data['errors'] = true;
					$data['message'] = 'Too short';
				}
				elseif($valid_username == 'naughty') {
					$data['errors'] = true;
					$data['message'] = 'No naughty words please';
				}
				elseif($valid_username == 'characters') {
					$data['errors'] = true;
					$data['message'] = 'Letters, numbers, underscores, and hyphens only';
				}
				elseif($valid_username == 'taken') {
					$data['errors'] = true;
					$data['message'] = 'Username is already taken';
				}
				elseif($valid_username == 'good') {
					//update_my_username($valid_username);
					$data['success'] = true;
					$data['message'] = ':)';
				}
			}
			else {
				$data['errors'] = true;
				$data['message'] = 'Please choose a username';
			}
		}

		echo json_encode($data);
	}
	else {
		do_redirect(get_landing());
	}
	

?>