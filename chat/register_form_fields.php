<?php
require_once("ajax_header.php");
 
	if (isset($_POST['username'])) {

		$username = $_POST['username'];
		$data = array();
		$valid_username = valid_username($username);

		if($valid_username) {
			if($valid_username == 'long') {
				$data['errors'] = true;
				$data['message'] = 'Username must contain fewer than 15 characters';
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
			$data['message'] = 'Please choose a username';
		}

	echo json_encode($data);

	}

	if(isset($_POST['email'])) {

		$email = $_POST['email'];
		$data = array();
		$valid_email = valid_email($email);

		if($valid_email) {
			$data['success'] = true;
			$data['message'] = 'All Good';
		}
		else {
			$data['errors'] = true;
			$data['message'] = 'Please enter a valid email';
		}

		echo json_encode($data);
	}

	if(isset($_POST['password'])) {

		$password = $_POST['password'];
		$data = array();
		$valid_password = valid_password($password);
		//$default_text = 'Your password must be between 6 and 15 characters, and include only letters, numbers, underscores (_), hyphens (-), !, @';

		if($valid_password) {
			if($valid_password == 'short') {
				$data['errors'] = true;
				$data['message'] = 'Your password must be between 6 and 15 characters';
			}
			if($valid_password == 'long') {
				$data['errors'] = true;
				$data['message'] = 'Your password must be between 6 and 15 characters';
			}
			if($valid_password == 'characters') {
				$data['errors'] = true;
				$data['message'] = 'You may only include letters, numbers, underscores (_), hyphens (-), !, @';
			}
			if($valid_password == 'good') {
				$data['success'] = true;
				$data['message'] = 'All Good';
			}			
		
		    if($valid_password == 'empty') {
				$data['errors'] = true;
				$data['message'] = 'Your password must be between 6 and 15 characters, and include only letters, numbers, underscores (_), hyphens (-), !, @';
			}
		}
		else {
			$data['errors'] = true;
			$data['message'] = 'There was an error, please try again';
		}

		echo json_encode($data);

	}

?>