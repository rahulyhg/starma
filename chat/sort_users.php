<?php
	require_once('ajax_header.php');

	/*
	if (isset($_POST['sort_by_sign'])) {
		$data = array();
		$errors = array();
		$sign_id = $_POST['sign_id']
		if (!preg_match('%[1-12]%', $sign_id)) {
			$errors['valid'] = 'something is wrong with this sign...';
		}
		if (!empty($errors)) {
			$data['errors'] = $errors;
		}
		else {
			$data['sign'] = get_sign_name($sign_id);
			//$data['sign'] = $sign_id
		}
		*/
		$data = get_sign_name(4);
		echo json_encode($data);
	//}



?>