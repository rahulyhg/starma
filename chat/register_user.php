<?php
require_once("ajax_header.php");

	$username = $_POST['username'];
	$year = $_POST['year_birthday'];
	$month = $_POST['month_birthday'];
	$day = $_POST['day_birthday'];
	$birthday = $year . "-" . $month . "-" . $day;  
	$email = $_POST['email'];
	//$email2 = $_POST['email2'];
	$password = $_POST['password'];
	//$agreement = $_POST['agreement'];
	$valid_username = valid_nickname($username);
	$valid_password = valid_pass($password); //MATT'S FUNCTION

	$data = array();
	$errors = array();
	//$output = validate_registration($username, $password, $password, $email, $email2, $year, $month, $day);
	//$data['success'] = false;
	//$data['failed'] = $output;
	//echo json_encode($data); 
	//$data = $username . ' ' . $year . ' ' . $month . ' ' . $day . ' ' . $birthday . ' ' . $email . ' ' . $email2 . ' ' . $password . ' ' . $valid_password; 
	//echo json_encode($data);
	if (!$valid_username) {
		$errors['username'] = 'Please enter a valid username';
	}
	if (!strtotime($birthday)) {
		$errors['strtotime'] = 'There was an error storing your birthday';
	}
	if ((int)(calculate_age(substr((string)$birthday, 0, 10))) < 18) {
		$errors['underage'] = 'You must be at least 18 to join Starma.com';
	}
	//if ($email != $email2) {
	//	$errors['email_match'] = 'Your emails need to match to continue';
	//}
	if (!valid_email($email)) {
		$errors['email_valid'] = 'Please enter a valid email';
	}
	if ($email == '') {
		$errors['email_empty'] = 'Please enter a valid email';
	}
	if ($valid_password == 'empty') {
		$errors['pass_empty'] = 'Please choose a password';
	}
	if ($valid_password == 'short') {
		$errors['pass_short'] = 'At least 6 characters';
	}
	if ($valid_password == 'long') {
		$errors['pass_long'] = 'No more than 15 characters';
	}
	if ($valid_password == 'characters') {
		$errors['pass_characters'] = 'Letters, numbers, underscores, hyphens, !, @';
	}

	if (!empty($errors)) {
		$data['success'] = false;
		$data['errors'] = $errors;
		echo json_encode($data);
	}
	else {
		/*
		$output = register_new_user($username, $password, $password, $email, $year, $month, $day);
		//$output = validate_registration($username, $password, $password, $email, $email2, $year, $month, $day);
		if (sizeof($output) <= 1)  {
			
        	log_this_action (account_action_user(), registered_basic_action(), -1, -1, -1, $output[0]);
          	if ($user = basic_user_data($output[0])) {
            	$data['user_there'] = 'User ' . $user["user_id"] . 'is there.<br>';
         	}
          	else {
            	$data['user_not_there'] = 'Failed to obtain User profile<br>';
          	}
          	//echo '*' . $output[0] . '*<br>';
          	//echo '*' . $user["user_id"] . '*<br>';
          	//print_r ($user); 
          	//die();
          	loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id']);
          	//do_redirect( $url = get_domain_sign_up(1);
          	//echo "Thank you for registering with Starma.com!  We have sent you an email with a verification link.  Please follow this link to activate your account.";        
          	*/
          	$data['success'] = true;
          	$data['url'] = get_domain_sign_up(1);
          	echo json_encode($data);
    	//}
    	/*
    	else {
        	//print_r ($output);
        	//echo $_POST["year_birthday"] . '-' . $_POST["month_birthday"] . '-' . $_POST["day_birthday"];
			$data['success'] = false;
			$data['failed'] = $output;
			echo json_encode($data); 
    	}
    	*/
    	
	}
	
	


?>