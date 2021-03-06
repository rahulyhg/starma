<?php
require_once("ajax_header.php");

	if  (isset($_POST['fb'])) {		//FACEBOOK REGISTRATION

		$username_fb = $_POST['username_fb'];
		$year_fb = $_POST['year_birthday_fb'];
		$month_fb = $_POST['month_birthday_fb'];
		$day_fb = $_POST['day_birthday_fb'];
		$birthday_fb = $year_fb . "-" . $month_fb . "-" . $day_fb;  
		$email_fb = $_POST['email_fb'];
		$valid_username_fb = valid_username($username_fb);
		$fb_id = $_SESSION['fb_id'];

		$data_fb = array();
		$errors = array();

		if ($valid_username_fb != 'good') {
			$errors['username_fb'] = 'Please enter a valid username';
		}
		if (!strtotime($birthday_fb)) {
			$errors['strtotime_fb'] = 'There was an error storing your birthday';
		}
		if ((int)(calculate_age(substr((string)$birthday_fb, 0, 10))) < 18) {
			$errors['underage_fb'] = 'You must be at least 18 to join Starma.com';
		}
		if (!valid_email($email_fb)) {
			$errors['email_valid_fb'] = 'Please enter a valid email';
		}
		if ($email_fb == '') {
			$errors['email_empty_fb'] = 'Please enter a valid email';
		}
		if ($fb_id == '') {
			$errors['fb_id'] = 'there was an error with your facebook id';
		}

		if (!empty($errors)) {
			$data_fb['success'] = false;
			$data_fb['errors'] = $errors;
		}
		else {
		
			$output_fb = register_new_user_fb($username_fb, $email_fb, $year_fb, $month_fb, $day_fb);
			if (sizeof($output_fb) <= 1)  {
			
        		log_this_action (account_action_user(), registered_basic_action(), -1, -1, -1, $output_fb[0]);
          		if ($user = basic_user_data($output_fb[0])) {
            		$data_fb['user_there'] = 'User ' . $user["user_id"] . 'is there.<br>';
         		}
          		else {
            		$data_fb['user_not_there'] = 'Failed to obtain User profile<br>';
          		}
          		//echo '*' . $output[0] . '*<br>';
          		//echo '*' . $user["user_id"] . '*<br>';
          		//print_r ($user); 
          		//die();
          		update_my_fb_id ($user['user_id'], $_SESSION['fb_id']);
          		loginUser($user['user_id'], $user['email'], $user['nickname'], $user['permissions_id'], $_SESSION['fb_id']);
          		set_my_preference('fb_connected', 1);
          		//do_redirect( $url = get_domain_sign_up(1);
          		//echo "Thank you for registering with Starma.com!  We have sent you an email with a verification link.  Please follow this link to activate your account.";        

          		$data_fb['success'] = true;
          		$data_fb['url_fb'] = 'sign_up.php';
    		}
    	
    		else {
        		//print_r ($output);
        		//echo $_POST["year_birthday"] . '-' . $_POST["month_birthday"] . '-' . $_POST["day_birthday"];
				$data_fb['success'] = false;
				$data_fb['failed'] = $output_fb;				 
    		}
    	 	
		}
		echo json_encode($data_fb);

	}
	else {		//REGULAR REGISTRATION

		$username = $_POST['username'];
		$year = $_POST['year_birthday'];
		$month = $_POST['month_birthday'];
		$day = $_POST['day_birthday'];
		$birthday = $year . "-" . $month . "-" . $day;  
		$email = $_POST['email'];
		$password = $_POST['password'];
		$valid_username = valid_username($username);
		$valid_password = valid_pass($password); //MATT'S FUNCTION

		$data = array();
		$errors = array();
		//$output = validate_registration($username, $password, $password, $email, $email2, $year, $month, $day);
		//$data['success'] = false;
		//$data['failed'] = $output;
		//echo json_encode($data); 
		//$data = $username . ' ' . $year . ' ' . $month . ' ' . $day . ' ' . $birthday . ' ' . $email . ' ' . $email2 . ' ' . $password . ' ' . $valid_password; 
		//echo json_encode($data);
		if ($valid_username != 'good') {
			$errors['username'] = 'Please enter a valid username';
		}
		if (!strtotime($birthday)) {
			$errors['strtotime'] = 'There was an error storing your birthday';
		}
		if ((int)(calculate_age(substr((string)$birthday, 0, 10))) < 18) {
			$errors['underage'] = 'You must be at least 18 to join Starma.com';
		}
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
		}
		else {
		
			$output = register_new_user($username, $password, $password, $email, $year, $month, $day);
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
          	
          		$data['success'] = true;
          		$data['url'] = 'sign_up.php';
    		}
    	
    		else {
        		//print_r ($output);
        		//echo $_POST["year_birthday"] . '-' . $_POST["month_birthday"] . '-' . $_POST["day_birthday"];
				$data['success'] = false;
				$data['failed'] = $output;				 
    		}
    	 	
		}
		echo json_encode($data);
	}

?>