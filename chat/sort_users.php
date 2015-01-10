<?php
	require_once('ajax_header.php');

	if (isset($_POST['sort_by_sign'])) {
		$data = array();
		$errors = array();
		if (!preg_match('%[a-zA-Z]%', $_POST['sign'])) {
			$errors['valid'] = 'something is wrong with this sign...';
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$data['sign'] = $_POST['sign'];
		}
		echo json_encode($data);
	}



?>