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
				$errors['exists'] = true;
			}
		}
		if (!loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id'])) {
			$errors['login'] = 'error at login';
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$data['sucess'] = true;
			//loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id']);
		}

	}


	echo json_encode($data);

?>