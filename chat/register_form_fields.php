<?php
require_once("ajax_header.php");
 
	if (isset($_POST['username'])) {

		$username = $_POST['username'];
		$data = array();
		$valid_username = valid_username($username);

		if($valid_username) {
			if($valid_username == 'long') {
				$data['errors'] = true;
				$data['message'] = 'Too long';
			}
			elseif($valid_username == 'short') {
				$data['errors'] = true;
				$data['message'] = 'Too short';
			}
			elseif($valid_username == 'naughty') {
				$data['errors'] = true;
				$data['message'] = 'No naughty words please';
			}
			elseif($valid_username == 'characters') {
				$data['errors'] = true;
				$data['message'] = 'Letters, numbers, underscores, and hyphens only';
			}
			elseif($valid_username == 'taken') {
				$data['errors'] = true;
				$data['message'] = 'Username is already taken';
			}
			elseif($valid_username == 'good') {
				$data['success'] = true;
				$data['message'] = ':)';
			}
		}
		else {
			$data['errors'] = true;
			$data['message'] = 'Please choose a username';
		}

	echo json_encode($data);

	}

	if(isset($_POST['year_birthday'])) {

		$year = $_POST['year_birthday'];
		$month = $_POST['month_birthday'];
		$day = $_POST['day_birthday'];
		$birthday = $year . "-" . $month . "-" . $day; 
		$data = array();
		//$data['message'] = $birthday;
		//$data['success'] = true;
		
		if (!strtotime($birthday)) {
			$data['errors'] = true;
			$data['message'] = 'There was an error storing your birthday';
		}
		elseif ((int)(calculate_age(substr((string)$birthday, 0, 10))) < 18) {
			$data['errors'] = true;
			$data['message'] = 'You must be at least 18 to join Starma.com';
		}
		else {
			$data['success'] = true;
			$data['message'] = ':)';
		}
	
		echo json_encode($data);
	}


	if(isset($_POST['email'])) {

		$email = $_POST['email'];
		$data = array();
		$valid_email = valid_email($email);

		if($valid_email) {
			$data['success'] = true;
			$data['message'] = ':)';
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
		$valid_password = valid_pass($password);
		//$default_text = 'Your password must be between 6 and 15 characters, and include only letters, numbers, underscores (_), hyphens (-), !, @';

		if($valid_password) {
			if($valid_password == 'short') {
				$data['errors'] = true;
				$data['message'] = 'At least 6 characters';
			}
			if($valid_password == 'long') {
				$data['errors'] = true;
				$data['message'] = 'No more than 15 characters';
			}
			if($valid_password == 'characters') {
				$data['errors'] = true;
				$data['message'] = 'Letters, numbers, underscores, hyphens, !, @';
			}
			if($valid_password == 'good') {
				$data['success'] = true;
				$data['message'] = ':)';
			}			
		
		    if($valid_password == 'empty') {
				$data['errors'] = true;
				$data['message'] = 'Please choose a password';
			}
		}
		else {
			$data['errors'] = true;
			$data['message'] = 'There was an error, please try again';
		}

		echo json_encode($data);

	}

?>