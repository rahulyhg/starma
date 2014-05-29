<?php 
require_once("ajax_header.php");
 
$logged_in = login_check_point($type="full");

$data = array();
$errors = array();

//if(trim($_POST["email"]) != "" and trim($_POST["text_body"]) != "") {
	//$data["success"] = true;

//}

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
	//send_invite_user($data["email"], $data["message"], $data["sender_id"]);
}




echo json_encode($data, true);


?>