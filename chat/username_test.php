<?php
require_once("ajax_header.php");
 
//if (isLoggedIn()) {

	$username = $_POST['username'];
	$data = array();
	$valid_username = valid_username($username);

	if($valid_username) {
		if($valid_username == 'long') {
			$data['errors'] = true;
			$data['message'] = 'Username must contain fewer than 21 characters';
		}
		elseif($valid_username == 'short') {
			$data['errors'] = true;
			$data['message'] = 'Username must contain at least 3 characters';
		}
		elseif($valid_username == 'naughty') {
			$data['errors'] = true;
			$data['message'] = 'No naughty words please';
		}
		elseif($valid_username == 'characters') {
			$data['errors'] = true;
			$data['message'] = 'Letters, numbers, underscores (_), and hyphens (-) only please';
		}
		elseif($valid_username == 'taken') {
			$data['errors'] = true;
			$data['message'] = 'That username is already taken';
		}
		elseif($valid_username == 'good') {
			$data['success'] = true;
			$data['message'] = 'All Good';
		}
	}
	else {
		$data['errors'] = true;
		$data['message'] = '* Please choose a username';
	}

	echo json_encode($data);

//}

?>