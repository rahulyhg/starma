<?php 
require_once("ajax_header.php");
 
if(isLoggedIn()) {

	
	$last_name = trim($_POST['last_name']);
	$their_name = trim($_POST['their_name']);
	$email = $_POST['email'];
	$text_body = $_POST['text_body'];
	$sender_user_id = $_POST['sender_user_id'];

	$data = array();
	$errors = array();

	if(isset($_POST['first_name'])) {
		$first_name = trim($_POST['first_name']);
		if($first_name == '') {
			$errors['first_name'] = 'Your first name is required';
		}
		elseif(!preg_match('%^[a-zA-Z0-9-]+&%', $first_name)) {
			$errors['first_name'] = 'There was an error processing your name';
		}
	}

	if(trim($_POST["email"]) == "" or !preg_match('%^[a-zA-Z0-9-_.]+@[a-zA-Z0-9-_.]+\.[A-Za-z]{2,4}$%', trim($_POST["email"]))) {
		$errors["email"] = "Please Enter a Valid Email";
	}
	else {
		$data["email"] = $_POST["email"];
	}

	if(trim($_POST["text_body"]) == "") {
		$errors["text_body"] = "We Can't Send a Blank Message!";
	}

	if(!empty($errors)) {
		$data["success"] = false;
		$data["errors"] = $errors;
	}
	else {
		$data["success"] = true;
		$data["message"] = $_POST["text_body"];
		$data["sender_id"] = $_POST["other_user_id"];
		//$data['message'] = $data["message"] + '<br><br><a href="' . get_domain() . '">Join Starma!</a><br><br><br>Sincerly,<br>The Starma Team<br><a href="' . get_domain() . '">www.starma.com</a>';
		send_invite_user($data["email"], $data["message"], $data["sender_id"]);
	}	

}


echo json_encode($data);


?>