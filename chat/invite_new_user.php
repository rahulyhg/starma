<?php 
require_once("ajax_header.php");
 
if(isLoggedIn()) {

	$data = array();
	$errors = array();

	//First Name
	if(isset($_POST['first_name'])) {
		$first_name = trim($_POST['first_name']);
		if($first_name == '' || $first_name == 'first name') {
			$errors['first_name'] = 'Your first name is required';
		}
		elseif(!preg_match('%^[a-zA-Z-]{2,17}$%', $first_name)) {
			$errors['first_name'] = 'There was an error processing your name';
		}
	}
	else {
		$data['success'] = false;
		$errors['first_name'] = 'Your first name is required';
	}

	//Last Name
	if(isset($_POST['last_name'])) {
		$last_name = trim($_POST['last_name']);
		if($last_name == '' || $last_name == 'last name') {
			$errors['last_name'] = 'Your last name is required';
		}
		elseif(!preg_match('%^[a-zA-Z-]{2,17}$%', $last_name)) {
			$errors['last_name'] = 'There was an error processing your name';
		}
	}
	else {
		$data['success'] = false;
		$errors['last_name'] = 'Your last name is required';
	}

	//Their Name
	if(isset($_POST['their_name'])) {
		$their_name = trim($_POST['their_name']);
		if($their_name == '' || $their_name == 'name') {
			$errors['their_name'] = 'Their name is required';
		}
		elseif(!preg_match('%^[a-zA-Z-\s]{2,30}$%', $their_name)) {
			$errors['their_name'] = 'There was an error processing their name';
		}
	}
	else {
		$data['success'] = false;
		$errors['their_name'] = 'Their name is required';
	}

	//Email
	if(isset($_POST['email'])) {
		$email = trim($_POST['email']);
		if($email == '') {
			$errors['email'] = 'Their email is required';
		}
		elseif(!preg_match ('%^[A-Za-z0-9._\%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$%', $email)) {
			$errors['email'] = 'Please enter a valid email';
		}
	}
	else {
		$data['success'] = false;
		$errors['email'] = 'Their email is required';
	}

	//Text Body
	if(isset($_POST['text_body'])) {
		$text_body = remove_slashes($_POST['text_body']);
		$text_body = remove_front_slashes($text_body);
		$text_body = strip_tags($text_body);
	}
	else {
		$text_body = '';
	}

	if(isset($_POST['sender_user_id'])) {
		$sender_user_id = $_POST['sender_user_id'];
	}
	else {
		$errors['sender_user_id'] = 'Something went wrong, please try again later';
	}

	if(!empty($errors)) {
		$data['success'] = false;
		$data['errors'] = $errors;
	}
	else {
		$data['success'] = true;
		$data = $first_name . ', ' . $last_name . ', ' . $their_name . ', ' . $email . ', ' . $text_body . ', ' . $sender_user_id;		
		//send_invite_user($first_name, last_name, $their_name, $email, $text_body, $sender_user_id);
	}	
	echo json_encode($data);
	
}

?>