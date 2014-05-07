<?php 
require_once("ajax_header.php");
 
$logged_in = login_check_point($type="full");

$data = array();
$errors = array();

if(trim($_POST["email"]) != "" and trim($_POST["text_body"]) != "") {
	$data["success"] = true;

}

if(trim($_POST["email"]) == "") {
	$errors["email"] = "Please Enter a Valid Email";
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
	$data["message"] = "Message Sent!";
}




echo json_encode($data, true);


?>