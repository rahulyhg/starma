<?php
	require_once('ajax_header.php');

	if (isset($_POST['fb_id'])) {
		$_SESSION['fb_id'] = $_POST['fb_id'];
		$fb_id = $_SESSION['fb_id'];
	}

	echo json_encode($fb_id);

?>