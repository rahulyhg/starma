<?php
	require_once('ajax_header.php');

	$data = array();
	$errors = array();

	if (isset($_POST['fb_id'])) {
		$_SESSION['fb_id'] = $_POST['fb_id'];
		$data['fb_id'] = $_SESSION['fb_id'];
		$data['check'] = 'got through';
	}

	if (isset($_POST['exist'])) {
		if (!$user_id = get_user_id_from_fb_id($_SESSION['fb_id'])) {
			$errors['user_id'] = 'Could not obtain user id';
			
		}
		else {
			if (!$user = user_exists_from_id($user_id)) {
				$errors['exists'] = 'does not exist';
			}
			//else {
			//	$data['user'] = $user;
			//}
		}
		//if (!loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id'])) {
		//	$errors['login'] = 'error at login';
		//}
		
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$data['success'] = true;
			loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id']);
			set_my_preference('fb_connected', 1);
		}

	}

	if (isset($_POST['reconnect_fb'])) {
		if(!set_my_preference('fb_connected', 1)) {
			$errors['set'] = 'Unable to set preference';
		}
		else {
			$data['success'] = true;
		}
	}


//FIND FB FRIENDS--------------------------------

	if (isset($_POST['fb_friends'])) {
		if (!$fb_friends = get_fb_friends()) {
			$errors['fb_friends'] = 'There was a problem accessing your Facebook friends';
		}
		else {
			$data['fb_friends'] = $fb_friends;
		}
	}


	echo json_encode($data);

?>