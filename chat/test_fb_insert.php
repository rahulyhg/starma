<?php
	require ('ajax_header.php');
	$data = array();
	$errors = array();

	if (isset($_POST['test']})) {
		$data['fb_id'] = update_my_fb_id ($_SESSION_['user_id'], $_SESSION['fb_id']);
		echo json_encode($data);
	}

?>