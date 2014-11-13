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

	}


	echo json_encode($data);

?>