<?php
require_once("ajax_header.php");

	$username = $_POST['username'];
	$year = $_POST['year_birthday'];
	$month = $_POST['month_birthday'];
	$day = $_POST['day_birthday'];
	$birthday = $year . "-" . $month . "-" . $day;  
	$email = $_POST['email'];
	$email2 = $_POST['email2'];
	$password = $_POST['password'];
	$agreement = $_POST['agreement'];
	$valid_password = valid_password($password);

	$data = array();
	$errors = array();

	if (!$agreement) {
		$errors['agreement'] = true;
		$data['agreement'] = 'You must read and agree to the Terms before continuing';
	}
	elseif (!strtotime($birthday)) {
		$errors['strtotime'] = true;
		$data['strtotime'] = 'There was an error storing your birthday';
	}
	elseif ((int)(calculate_age(substr((string)$birthday, 0, 10))) < 18) {
		$errors['underage'] = true;
		$data['underage'] = 'You must be at least 18 to join Starma.com';
	}
	elseif ($email != $email2) {
		$errors['email_match'] = true;
		$data['email_match'] = 'Your emails need to match to continue';
	}
	elseif (!valid_email($email)) {
		$errors['email_valid'] = true;
		$data['email_valid'] = 'Please enter a valid email';
	}
	elseif ($valid_password == 'empty') {
		$errors['pass_empty'] = true;
		$data['pass_empty'] = 'Please choose a password';
	}
	elseif ($valid_password == 'short') {
		$errors['pass_short'] = true;
		$data['pass_short'] = 'Your password must be between 6 and 15 characters';
	}
	elseif ($valid_password == 'long') {
		$errors['pass_long'] = true;
		$data['pass_long'] = 'Your password must be between 6 and 15 characters';
	}
	elseif ($valid_password == 'characters') {
		$errors['pass_characters'] = true;
		$data['pass_characters'] = 'You may only include letters, numbers, underscores (_), hyphens (-), !, @';
	}

	if (!empty($errors)) {
		$data['success'] = false;
		$data['errors'] = $errors;
		echo json_encode($data)
	}
	else {
		registerNewUser($username, $password, $password, $email, $email2, $year, $month, $day, $agreement);
		//$data['success'] = true;
		log_this_action (account_action_user(), registered_basic_action(), -1, -1, -1, $output[0]);
		if ($user = basic_user_data($output[0])) {
            echo 'User ' . $user["user_id"] . 'is there.<br>';
        }
        else {
            echo 'Failed to obtain User profile<br>';
        }

		loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id']);
        do_redirect( $url = get_domain() . '/' . get_landing());
	}

	


?>