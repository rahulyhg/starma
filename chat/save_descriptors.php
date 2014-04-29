<?php
session_start();
    require_once ('../include/db_connect.inc.php'); 
    require_once ("../include/functions.inc.php"); 
    require_once ("../PHPMailer_5.2.1/class.phpmailer.php");
    date_default_timezone_set('America/Chicago');
 
$logged_in = login_check_point($type="full");

	$data = array();
	if($_POST["user_des_id"] != null && $_POST["value"] != null) {
		$data["user_des_id"] = $_POST["user_des_id"];
		$data["post_value"] = $_POST["value"];
		$user_des_id = $_POST["user_des_id"];
		$value = $_POST["value"];
		update_my_single_descriptor ($user_des_id, $value);
		echo json_encode($data, true);
	}
	else {
		$data = 'one post was null';
		echo json_encode($data, true);
	}
	
	//$data = 'hello';
	//echo json_encode($data, true);

?>