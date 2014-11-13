<?php
	require ('ajax_header.php');
	$data = array();
	$errors = array();

	if (isset($_POST['test'])) {
		if (!update_my_fb_id($_SESSION['user_id'], $_SESSION['fb_id'])) {
			$errors['update'] = 'error updating';
		}
		if (!empty($errors)){
			$data['errors'] = $errors;
		}
		else {
			$data['fb_id'] = 'Success!';
		}
		echo json_encode($data);
	}

?>